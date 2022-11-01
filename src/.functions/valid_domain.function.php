<?php

if (!function_exists('valid_domain')) {




function valid_domain($pqdn) {
	$domain_info = \AppDomain::getDomainValidator()->parse($pqdn);
	return ($domain_info->isValidDomain() && stripos($domain_info->getRegistrableDomain(), 'www.') !== 0);
}
}
