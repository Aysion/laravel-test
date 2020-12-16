<?php

use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\JWK;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Algorithm\HS512;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer;

class JWTHelper
{

	private $algorithmManager = null;
	private $jwk = null;

	public function __construct()
	{
		$this->algorithmManager = new AlgorithmManager([
			new HS512(),
		]);

		$this->jwk = new JWK([
			'kty' => 'oct',
			'k' => env('JWT_KEY'),
		]);
	}

	public function build($dataPayload)
	{
		$time = time();

		$payload = json_encode([
			'iat' => $time,
			'nbf' => $time,
			'exp' => $time + 3600,
			'payload' => $dataPayload,
		]);

		$jws = (new JWSBuilder($this->algorithmManager))->create()->addSignature($this->jwk, ['alg' => 'HS512'])->withPayload($payload)->build();

		return (new CompactSerializer())->serialize($jws, 0);
	}

	public function getOctKey() {
		return JWKFactory::createOctKey(2048, [ 'alg' => 'PS512', 'use' => 'sig' ]);
	}
}
