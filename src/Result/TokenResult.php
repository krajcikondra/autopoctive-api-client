<?php

namespace Autopoctive\ApiClient\Result;

class TokenResult {

	/** @var  string */
	protected $accessToken;

	/** @var  int */
	protected $expiresIn;

	/** @var  string */
	protected $refreshToken;


	/**
	 * TokenResult constructor.
	 * @param string $accessToken
	 * @param int    $expiresIn
	 * @param string $refreshToken
	 */
	public function __construct($accessToken, $expiresIn, $refreshToken) {
		$this->accessToken = $accessToken;
		$this->expiresIn = $expiresIn;
		$this->refreshToken = $refreshToken;
	}

	/**
	 * @return string
	 */
	public function getAccessToken(): string {
		return $this->accessToken;
	}

	/**
	 * @param string $accessToken
	 */
	public function setAccessToken(string $accessToken) {
		$this->accessToken = $accessToken;
	}

	/**
	 * @return int
	 */
	public function getExpiresIn(): int {
		return $this->expiresIn;
	}

	/**
	 * @param int $expiresIn
	 */
	public function setExpiresIn(int $expiresIn) {
		$this->expiresIn = $expiresIn;
	}

	/**
	 * @return string
	 */
	public function getRefreshToken(): string {
		return $this->refreshToken;
	}

	/**
	 * @param string $refreshToken
	 */
	public function setRefreshToken(string $refreshToken) {
		$this->refreshToken = $refreshToken;
	}


}