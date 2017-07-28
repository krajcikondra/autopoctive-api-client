<?php

namespace Autopoctive\ApiClient;


use Autopoctive\ApiClient\Result\TokenResult;

class Client {

	const GRANT_CLIENT_CREDENTIALS = 'client_credentials';


	/** @var  \GuzzleHttp\Client */
	protected $httpClient;

	// @todo upravit tak abych se nemusel prihlasovat a prihlasovalo se to automaticky + automaticke refreshovani tokenu

	/**
	 * Client constructor.
	 */
	public function __construct() {
		$this->httpClient = new \GuzzleHttp\Client();
	}


	/**
	 * @param string $apiClientId
	 * @param string $clientSecret
	 * @return TokenResult
	 */
	public function authorize($apiClientId, $clientSecret) {
		$res = $this->httpClient->request('POST', 'http://localhost/auto-moto-inzerce/www/rest-api/v1/token', [
			'form_params' => [
				'grant_type' => self::GRANT_CLIENT_CREDENTIALS,
				'client_id' => $apiClientId,
				'client_secret' => $clientSecret,
			]
		]);

		$result = (array) json_decode($res->getBody()->getContents());

		return new TokenResult(
			$result['access_token'],
			$result['expires_in'],
			$result['refresh_token']
		);
	}


	/**
	 * @param string $accessToken
	 * @return array
	 */
	public function getMarks($accessToken) {
		$res = $this->httpClient->request('GET', 'http:/localhost/auto-moto-inzerce/www/rest-api/v1/marks', [
			'headers' => [
				'Authorization' => 'Bearer ' . $accessToken,
			]
		]);

		return (array) json_decode($res->getBody()->getContents());
	}


	/**
	 * @param string $accessToken
	 * @return array
	 */
	public function getEquipments($accessToken) {
		$res = $this->httpClient->request('GET', 'http:/localhost/auto-moto-inzerce/www/rest-api/v1/equipments', [
			'headers' => [
				'Authorization' => 'Bearer ' . $accessToken,
			]
		]);

		return (array) json_decode($res->getBody()->getContents());
	}


	/**
	 * @param string    $accessToken
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
	public function addAdvertisement(
		$accessToken,
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
		$res = $this->httpClient->request('PUT', 'http:/localhost/auto-moto-inzerce/www/rest-api/v1/advertisement', [
			'headers' => [
				'Authorization' => 'Bearer ' . $accessToken,
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
	 * @param string $accessToken
	 * @param int $advertisementId
	 * @param string $imagePath
	 * @return array
	 */
	public function uploadImage($accessToken, $advertisementId, $imagePath) {
		$res = $this->httpClient->request('PUT', 'http:/localhost/auto-moto-inzerce/www/rest-api/v1/advertisement/upload-image', [
			'headers' => [
				'Authorization' => 'Bearer ' . $accessToken,
			],
			'json' => [
				'advertisement_id' => $advertisementId,
				'fuel' => file_get_contents($imagePath),
				'name' => basename($imagePath),
			]
		]);
		return (array) json_decode($res->getBody()->getContents());
	}


	/**
	 * @param string 	$accessToken
	 * @param int 		$advertisementId
	 * @return array
	 */
	public function publicAdvertisement($accessToken, $advertisementId) {
		$res = $this->httpClient->request('PUT', 'http:/localhost/auto-moto-inzerce/www/rest-api/v1/advertisement/public', [
			'headers' => [
				'Authorization' => 'Bearer ' . $accessToken,
			],
			'json' => [
				'advertisement_id' => $advertisementId,
			]
		]);
		return (array) json_decode($res->getBody()->getContents());
	}


}
