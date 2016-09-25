<?php
namespace Instakler\Exceptions;

/**
 * Class ResponseException
 * @package Instakler\Exceptions
 */
class ResponseException
{
    /**
     * @param \GuzzleHttp\Psr7\Response $response
     *
     * @throws APIInvalidParametersError
     * @throws APINotAllowedError
     * @throws APINotFoundError
     * @throws OAuthAccessTokenException
     * @throws OAuthParameterException
     * @throws OAuthRateLimitException
     * @throws \HttpException
     */
    public function check(\GuzzleHttp\Psr7\Response $response)
    {
        $data = json_decode($response->getBody()->getContents(), true);
        if (isset($data['meta']['error_type'])) {
            $errorType = $data['meta']['error_type'];
            $errorMessage = $data['meta']['error_message'];
            $errorCode = $data['meta']['code'];
            switch ($errorType)
            {
                case 'OAuthParameterException':
                    throw new OAuthParameterException($errorMessage, $errorCode);
                    break;
                case 'OAuthRateLimitException':
                    throw new OAuthRateLimitException($errorMessage, $errorCode);
                    break;
                case 'OAuthAccessTokenException':
                    throw new OAuthAccessTokenException($errorMessage, $errorCode);
                    break;
                case 'APINotFoundError':
                    throw new APINotFoundError($errorMessage, $errorCode);
                    break;
                case 'APINotAllowedError':
                    throw new APINotAllowedError($errorMessage, $errorCode);
                    break;
                case 'APIInvalidParametersError':
                    throw new APIInvalidParametersError($errorMessage, $errorCode);
                    break;
            }
        }

        switch ($response->getStatusCode())
        {
            case 500:
            case 502:
            case 503:
            case 400:
                throw new \HttpException($response->getReasonPhrase(), $response->getStatusCode());
                break;
            case 429:
                throw new OAuthRateLimitException($data['meta']['error_type'], 429);
                break;
            default:
                break;
        }
    }
}
