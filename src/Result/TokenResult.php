<?php

namespace Autopoctive\ApiClient\Result;

use Nette\DateTime;

class TokenResult {

	/** @var  string */
	protected $accessToken;

	/** @var  int */
	protected $expiresIn;

	/** @var  \DateTime */
	protected $expiresAt;

	/** @var  string */
	protected $refreshToken;


	/**
	 * TokenResult constructor.
	 * @param string    $accessToken
	 * @param int       $expiresIn
	 * @param string    $refreshToken
	 * @param \DateTime $expiresAt
	 */
	public function __construct($accessToken, $expiresIn, $refreshToken, \DateTime $expiresAt) {
		$this->accessToken = $accessToken;
		$this->expiresIn = $expiresIn;
		$this->refreshToken = $refreshToken;
		$this->expiresAt = $expiresAt;
	}

	/**
	 * @return string
	 */
	public function getAccessToken() {
		return $this->accessToken;
	}

	/**
	 * @return int
	 */
	public function getExpiresIn() {
		return $this->expiresIn;
	}

	/**
	 * @return string
	 */
	public function getRefreshToken() {
		return $this->refreshToken;
	}

	/**
	 * @return \DateTime
	 */
	public function getExpiresAt() {
		return $this->expiresAt;
	}

	/**
	 * Is token valid?
	 * @return bool
	 */
	public function isValid() {
		$now = new DateTime();
		return $now <  $this->expiresAt;
	}

}
