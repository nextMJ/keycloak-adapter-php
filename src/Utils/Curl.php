<?php
    /**
     * Created by PhpStorm.
     * User: miroslav
     * Date: 23/04/2019
     * Time: 09:03
     */

    namespace Ataccama\Utils;


    use Ataccama\Exceptions\CurlTimeout;
    use Ataccama\Exceptions\CurlException;

    class Curl
    {
        private static function init_request(string $url, bool $local_development) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5); //timeout in seconds

            if ($local_development === true) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            }

            return $ch;
        }

        private static function handle_curl_errors($ch) {
            if (curl_error($ch)) {
                // https://timi.eu/docs/anatella/5_1_9_1_list-of-curl-error-co.html
                if ((curl_errno($ch) === 7) || (curl_errno($ch) === 28)) {
                    throw new CurlTimeout();
                }
                throw new CurlException("Curl Error (".curl_errno($ch)."): " . curl_error($ch));
            }
        }

        /**
         * @param string $url
         * @param array  $headers
         * @param mixed  $parameters
         * @return Response
         * @throws CurlException
         */
        public static function post(string $url, array $headers = [], $parameters = null, bool $local_development = false, $json_answer = true): Response
        {
            $ch = Curl::init_request($url, $local_development);
            
            if (!empty($parameters)) {
                if (is_array($parameters)) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
                } else {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
                }
            }

            if (!empty($headers)) {
                $h = [];
                foreach ($headers as $key => $header) {
                    $h[] = "$key: $header";
                }
                curl_setopt($ch, CURLOPT_HTTPHEADER, $h);
            }

            curl_setopt($ch, CURLOPT_POST, true);

            $response = curl_exec($ch);

            Curl::handle_curl_errors($ch);

            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            if ($json_answer) {
                return new Response($httpcode, json_decode($response), null);   // errors are handled by exceptions
            } else {
                return new Response($httpcode, $response, null);   // errors are handled by exceptions
            }
        }

        /**
         * @param string $url
         * @param array  $headers
         * @param null   $parameters
         * @return Response
         * @throws CurlException
         */
        public static function put(string $url, array $headers = [], $parameters = null, bool $local_development = false): Response
        {
            $ch = Curl::init_request($url, $local_development);

            if (!empty($parameters)) {
                if (is_array($parameters)) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
                } else {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
                }
            }

            if (!empty($headers)) {
                $h = [];
                foreach ($headers as $key => $header) {
                    $h[] = "$key: $header";
                }
                curl_setopt($ch, CURLOPT_HTTPHEADER, $h);
            }

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

            $response = curl_exec($ch);

            Curl::handle_curl_errors($ch);

            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            return new Response($httpcode, json_decode($response), null);   // errors are handled by exceptions
        }

        /**
         * @param string $url
         * @param array  $headers
         * @return Response
         * @throws CurlException
         */
        public static function get(string $url, array $headers = [], bool $local_development = false): Response
        {
            $ch = Curl::init_request($url, $local_development);

            if (!empty($headers)) {
                $h = [];
                foreach ($headers as $key => $header) {
                    $h[] = "$key: $header";
                }
                curl_setopt($ch, CURLOPT_HTTPHEADER, $h);
            }

            $response = curl_exec($ch);

            Curl::handle_curl_errors($ch);

            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            return new Response($httpcode, json_decode($response), null);   // errors are handled by exceptions
        }

        /**
         * @param string $url
         * @param array  $headers
         * @return Response
         * @throws CurlException
         */
        public static function delete(string $url, array $headers = [], bool $local_development = false): Response
        {
            $ch = Curl::init_request($url, $local_development);

            if (!empty($headers)) {
                $h = [];
                foreach ($headers as $key => $header) {
                    $h[] = "$key: $header";
                }
                curl_setopt($ch, CURLOPT_HTTPHEADER, $h);
            }

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            
            $response = curl_exec($ch);

            Curl::handle_curl_errors($ch);

            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            return new Response($httpcode, json_decode($response), null);   // errors are handled by exceptions
        }
    }