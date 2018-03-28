<?php

namespace App\Http\Controllers;

use App\Auth\EmailAccountType;
use App\Model\System\ApiAuth;
use App\Validation\AuthValidation;
use Nilnice\Phalcon\Http\Response;
use Phalcon\Filter;
use Phalcon\Paginator\Adapter\QueryBuilder;
use Phalcon\Security;

/**
 * @property \App\Provider\AuthServiceProvider $auth
 */
class ApiAuthController extends AbstractController
{
    /**
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function indexAction(): Response
    {
        return $this->successResponse(__METHOD__);
    }

    /**
     * Create user.
     *
     * @return \Nilnice\Phalcon\Http\Response
     *
     * @throws \Phalcon\Security\Exception
     */
    public function createAction(): Response
    {
        $data = $this->request->getPost();
        $validation = new AuthValidation();
        $validation->createValidate($data);
        $validator = $this->validator($validation, $data);

        if ($validator['message']) {
            return $this->warningResponse($validator['message'], $validator);
        }

        // Filter post data.
        $filter = new Filter();
        $email = $filter->sanitize($data['email'], ['trim', 'email']);
        $username = $filter->sanitize($data['username'], ['trim']);
        $password = $filter->sanitize($data['password'], ['trim']);

        $app = self::generateAppIdAndSecret();
        $apiAuth = new ApiAuth();
        $apiAuth->setEmail($email);
        $apiAuth->setUsername($username);
        $apiAuth->setAppId($app['app_id']);
        $apiAuth->setAppSecret($app['app_secret']);
        $apiAuth->setPassword($this->security->hash($password));
        $apiAuth->setRoleId('1'); // 默认角色为用户
        $apiAuth->setIsVerifiedEmail();

        if ($apiAuth->save()) {
            $apiAuth->setCreatorId($apiAuth->getId());
            $apiAuth->setModifierId($apiAuth->getId());
            $apiAuth->save();

            return $this->successResponse('注册成功');
        }

        return $this->warningResponse('注册失败');
    }

    /**
     * Update user information.
     *
     * @param null|string $id
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function updateAction($id = null): Response
    {
        if (! $id) {
            return $this->warningResponse('Invalid parameter');
        }

        /** @var \App\Model\System\ApiAuth $entity */
        $entity = ApiAuth::findFirst([
            'conditions' => 'id=:id:',
            'bind'       => ['id' => $id],
        ]);

        if (! $entity) {
            return $this->warningResponse('User not found');
        }

        $array = $this->getRaw();
        $array['id'] = $id;
        $validation = new AuthValidation();
        $validation->updateValidate($array);
        $validator = $this->validator($validation, $array);

        if ($validator['message']) {
            return $this->warningResponse($validator['message'], $validator);
        }

        $entity->setEmail($array['email'] ?? $entity->getEmail());
        $entity->setUsername($array['username'] ?? $entity->getUsername());

        if (! $entity->update()) {
            return $this->warningResponse('更新失败');
        }

        return $this->successResponse('更新成功');
    }

    /**
     * Get some users list.
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function listAction(): Response
    {
        $limit = 10;
        $builder = $this->modelsManager
            ->createBuilder()
            ->columns('*')
            ->from(ApiAuth::class)
            ->where(true)
            ->andWhere('isDelete=:isDelete:', ['isDelete' => false])
            ->orderBy('createdAt DESC');

        $paginator = new QueryBuilder(
            [
                'builder' => $builder,
                'limit'   => $limit,
                'page'    => 1,
            ]
        );
        $array = [
            'total' => $paginator->getPaginate()->total_items,
            'pages' => $paginator->getPaginate()->total_pages,
            'page'  => $paginator->getCurrentPage(),
            'limit' => $paginator->getLimit(),
            'list'  => $paginator->getPaginate()->items,
        ];

        return $this->successResponse('用户列表', $array);
    }

    /**
     * Delete user account.
     *
     * @param null|string $id
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function deleteAction($id = null): Response
    {
        if (! $id) {
            return $this->warningResponse('Invalid parameter');
        }

        /** @var \App\Model\System\ApiAuth $entity */
        $entity = ApiAuth::findFirst([
            'conditions' => 'id=:id: AND isDelete=:isDelete:',
            'bind'       => ['id' => $id, 'isDelete' => false],
        ]);

        if (! $entity) {
            return $this->warningResponse('Not found user');
        }

        $entity->setIsDelete(true);

        if (! $entity->save()) {
            return $this->warningResponse('删除失败');
        }

        return $this->successResponse('删除成功');
    }

    /**
     * User authorize.
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function authorizeAction(): Response
    {
        $request = $this->request;
        $username = $request->getUsername();
        $password = $request->getPassword();

        ['token' => $token, 'uid' => $uid]
            = $this->auth->loginWithUsernamePassword(
            EmailAccountType::NAME,
            $username,
            $password
        );

        $columns = (new ApiAuth())->columnMap();
        $auth = ApiAuth::findFirst([
            'columns'    => $columns,
            'conditions' => 'id=:id:',
            'bind'       => ['id' => $uid],
        ]);

        $data = [
            'token' => $token,
            'user'  => $auth ? $auth->toArray() : [],
        ];

        return $this->successResponse('授权 Access token', $data);
    }

    /**
     * Get token detail.
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function detailAction(): Response
    {
        /** @var \Nilnice\Phalcon\Auth\JWTAuth $auth */
        $auth = $this->getDI()->get('auth');

        $data = ['token' => '', 'uid' => ''];
        if ($auth) {
            $data['token'] = ($auth->getToken()->__toString());
            $data['uid'] = $auth->getToken()->getClaim('uid');
        }

        return $this->successResponse('Token 信息', $data);
    }

    /**
     * @return array
     *
     * @throws \Phalcon\Security\Exception
     */
    private static function generateAppIdAndSecret(): array
    {
        $random = (new Security())->getRandom();
        $appId = $random->hex(16);
        $appSecret = $random->base64Safe(16);

        while (true) {
            $parameter = [
                'conditions' => 'appId=:appId:',
                'bind'       => ['appId' => $appId],
            ];
            if (! ApiAuth::count($parameter)) {
                break;
            }
        }

        while (true) {
            $parameter = [
                'conditions' => 'appSecret=:appSecret:',
                'bind'       => ['appSecret' => $appSecret],
            ];
            if (! ApiAuth::count($parameter)) {
                break;
            }
        }

        return ['app_id' => $appId, 'app_secret' => $appSecret];
    }
}
