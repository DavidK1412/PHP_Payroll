<?php
    require_once '../domain/exceptions/TokenNotFoundedException.php';
    require_once('../../../vendor/autoload.php');

    use \Firebase\JWT\JWT;
    use \Firebase\JWT\Key;

    $secretKey = '68_0zVWFrS72GbpRiptideidkQFLfj4v9m3Ti+HighTCS=';

    function generateToken(UserModel $user) {
        global $secretKey;
        $issuedAt = time();
        $expire = $issuedAt + 300;
        $payload = array(
            'userid' => $user->getUserId(),
            'userTypePermission' => $user->getEmployee()->getPosition()->getPositionId(),
            'issuedAt' => $issuedAt,
            'expire' => $expire
        );
        return JWT::encode($payload, $secretKey, 'HS256');
    }

    function validateToken($token) {
        global $secretKey;

        try{
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
            $issuedAt = $decoded->issuedAt;
            $expire = $decoded->expire;
            $currentTime = time();
        } catch (Exception $e){
            throw new TokenNotFoundedException();
        }

        if($currentTime > $issuedAt && $currentTime < $expire){
            return true;
        }
        return false;
    }

    function getDecodedToken($token) {
        global $secretKey;
        return JWT::decode($token, new Key($secretKey, 'HS256'));
    }
?>