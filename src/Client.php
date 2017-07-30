<?php

namespace Autopoctive\ApiClient;

use Autopoctive\ApiClient\Result\TokenResult;


/**
 * Class Client
 * @package Autopoctive\ApiClient
 */
class Client {

	const GRANT_CLIENT_CREDENTIALS = 'client_credentials';
	const URL = 'http://localhost/auto-moto-inzerce/www';


	/** @var  \GuzzleHttp\Client */
	protected $httpClient;

	/** @var  string */
	private $apiClientId;

	/** @var  string */
	private $clientSecret;

	/** @var  TokenResult|null */
	private $accessTokenResult;


	/**
	 * Client constructor.
	 * @param string $apiClientId
	 * @param string $clientSecret
	 */
	public function __construct($apiClientId, $clientSecret) {
		$this->httpClient = new \GuzzleHttp\Client();
		$this->apiClientId = $apiClientId;
		$this->clientSecret = $clientSecret;
	}


	/**
	 * @return array
	 */
	public function getMarks() {
		$res = $this->httpClient->request('GET', self::URL . '/rest-api/v1/marks', [
			'headers' => [
				'Authorization' => 'Bearer ' . $this->getAccessToken(),
			]
		]);

		return (array) json_decode($res->getBody()->getContents());
	}


	/**
	 * @return array
	 */
	public function getEquipments() {
		$res = $this->httpClient->request('GET', self::URL . '/rest-api/v1/equipments', [
			'headers' => [
				'Authorization' => 'Bearer ' . $this->getAccessToken(),
			]
		]);

		return (array) json_decode($res->getBody()->getContents());
	}


	/**
	 * @param string    $fuel
	 * @param int       $performance
	 * @param int       $price
	 * @param int       $made
	 * @param int       $markId
	 * @param string    $model
	 * @param string	$description
	 * @param int       $kilometers
	 * @param string    $condition
	 * @param int       $doorCount
	 * @param int       $engineDisplacement
	 * @param string    $bodywork
	 * @param string    $transmission
	 * @param string    $phone
	 * @param \DateTime $validStkTo
	 * @param int[]     $equipments
	 * @param int       $frontTiresCondition
	 * @param int       $rearTiresCondition
	 * @param string    $vinCode
	 * @param bool      $serviceBook
	 * @param float     $consumption
	 * @param string    $wheelDrive
	 * @param int       $maxSpeed
	 * @param bool      $importation
	 * @param int       $ownerNumber
	 * @return array
	 */
	public function createAdvertisement(
		$fuel,
		$performance,
		$price,
		$made,
		$markId,
		$model,
		$description,
		$kilometers,
		$condition,
		$doorCount,
		$engineDisplacement,
		$bodywork,
		$transmission,
		$phone,
		\DateTime $validStkTo,
		$equipments,
		$frontTiresCondition,
		$rearTiresCondition,
		$vinCode,
		$serviceBook,
		$consumption,
		$wheelDrive,
		$maxSpeed,
		$importation,
		$ownerNumber
	) {
		$res = $this->httpClient->request('PUT', self::URL . '/rest-api/v1/advertisement', [
			'headers' => [
				'Authorization' => 'Bearer ' . $this->getAccessToken(),
			],
			'json' => [
				'fuel' => $fuel,
				'performance' => (int) $performance,
				'price' => $price,
				'made' => (int) $made,
				'markId' => (int) $markId,
				'model' => $model,
				'description' => $description,
				'kilometers' => $kilometers,
				'condition' => $condition,
				'doorCount' => (int) $doorCount,
				'engineDisplacement' => (int) $engineDisplacement,
				'bodywork' => $bodywork,
				'transmission' => $transmission,
				'phone' => $phone,
				'validStkTo' => $validStkTo->format('Y-m-d'),
				'equipments' => $equipments,
				'frontTiresCondition' => (int) $frontTiresCondition,
				'rearTiresCondition' => (int) $rearTiresCondition,
				'vinCode' => (string) $vinCode,
				'serviceBook' => (bool) $serviceBook,
				'consumption' => (float) $consumption,
				'wheelDrive' => (string) $wheelDrive,
				'maxSpeed' => (int) $maxSpeed,
				'importation' => (bool) $importation,
				'ownerNumber' => (int) $ownerNumber,
			]
		]);

		return (array) json_decode($res->getBody()->getContents());
	}


	/**
	 * @param int $advertisementId
	 * @param string $imagePath
	 * @return array
	 */
	public function uploadImage($advertisementId, $imagePath) {
		$res = $this->httpClient->request('PUT', self::URL . '/rest-api/v1/advertisement/upload-image', [
			'headers' => [
				'Authorization' => 'Bearer ' . $this->getAccessToken(),
			],
			'json' => [
				'advertisement_id' => $advertisementId,
				'content' => base64_encode(file_get_contents($imagePath)),
				'name' => basename($imagePath),
			]
		]);
		return (array) json_decode($res->getBody()->getContents());
	}


	/**
	 * @param int 		$advertisementId
	 * @return array
	 */
	public function publicAdvertisement($advertisementId) {
		$res = $this->httpClient->request('PUT', self::URL . '/rest-api/v1/advertisement/public', [
			'headers' => [
				'Authorization' => 'Bearer ' . $this->getAccessToken(),
			],
			'json' => [
				'advertisement_id' => $advertisementId,
			]
		]);
		return (array) json_decode($res->getBody()->getContents());
	}


	/**
	 * @param int 		$advertisementId
	 * @return array
	 */
	public function deleteAdvertisement($advertisementId) {
		$res = $this->httpClient->request('DELETE', self::URL . '/rest-api/v1/advertisement', [
			'headers' => [
				'Authorization' => 'Bearer ' . $this->getAccessToken(),
			],
			'json' => [
				'advertisement_id' => $advertisementId,
			]
		]);
		return (array) json_decode($res->getBody()->getContents());
	}


	/**
	 * @return TokenResult
	 */
	private function authorize() {
		$res = $this->httpClient->request('POST', self::URL . '/rest-api/v1/token', [
			'form_params' => [
				'grant_type' => self::GRANT_CLIENT_CREDENTIALS,
				'client_id' => $this->apiClientId,
				'client_secret' => $this->clientSecret,
			]
		]);

		$result = (array) json_decode($res->getBody()->getContents());

		return $this->accessTokenResult = new TokenResult(
			$result['access_token'],
			$result['expires_in'],
			$result['refresh_token'],
			new \DateTime($result['expires_at'])
		);
	}


	/**
	 * @return string
	 */
	private function getAccessToken() {
		if ($this->accessTokenResult && $this->accessTokenResult->isValid()) {
			return $this->accessTokenResult->getAccessToken();
		} elseif ($this->accessTokenResult && !$this->accessTokenResult->isValid()) {
			// @todo misto uplne noveho access tokenu generovat access token pres refresh token
			return $this->authorize()->getAccessToken();
		}

		return $this->authorize()->getAccessToken();
	}


}
