<?php

use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\JWK;
use Jose\Component\Signature\Algorithm\ES512;
use Jose\Component\Signature\Algorithm\HS512;
use Jose\Component\Signature\Algorithm\PS512;
use Jose\Component\Signature\Algorithm\RS512;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer;

class JWTHelper
{

	private $algorithmManager = null;
	private $jwk = null;

	public function __construct()
	{
		$this->algorithmManager = new AlgorithmManager([
			new ES512(),
			new PS512(),
			new HS512(),
			new RS512(),
		]);

		$this->jwk = new JWK([
			'kty' => 'oct',
			'k' => 'dzI6nbW4OcNF-AtfxGAmuyz7IpHRudBI0WgGjZWgaRJt6prBn3DARXgUR8NVwKhfL43QBIU2Un3AvCGCHRgY4TbEqhOi8-i98xxmCggNjde4oaW6wkJ2NgM3Ss9SOX9zS3lcVzdCMdum-RwVJ301kbin4UtGztuzJBeg5oVN00MGxjC2xWwyI0tgXVs-zJs5WlafCuGfX1HrVkIf5bvpE0MQCSjdJpSeVao6-RSTYDajZf7T88a2eVjeW31mMAg-jzAWfUrii61T_bYPJFOXW8kkRWoa1InLRdG6bKB9wQs9-VdXZP60Q4Yuj_WZ-lO7qV9AEFrUkkjpaDgZT86w2g',
		]);
	}

	public function build()
	{
		$time = time();

		$payload = json_encode([
			'iat' => $time,
			'nbf' => $time,
			'exp' => $time + 3600,
			'iss' => 'Laravel',
			'aud' => 'CRM-Application',
		]);

		$jws = (new JWSBuilder($this->algorithmManager))
		->create()
		->addSignature($this->jwk, ['alg' => 'HS512'])
		->withPayload($payload)
		->build();

		$serializer = new CompactSerializer();

		$token = $serializer->serialize($jws, 0);;

		return $token;
	}
}
