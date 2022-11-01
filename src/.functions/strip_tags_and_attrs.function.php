<?php

if (!function_exists('strip_tags_and_attrs')) {
function strip_tags_and_attrs($html_str, $allowed_tags = NULL, $allowed_attrs = NULL) {
	if (strlen($html_str)) {
		
		// List the tags you want to allow here
		if (is_null($allowed_tags))
			$allowed_tags = array("b", "br", "em", "hr", "i", "li", "ol", "p", "s", "span", "table", "tr", "td", "u", "ul");
		
		if (is_array($allowed_tags))
			$allowed_tags = array_flip($allowed_tags);
		
		if (!empty($allowed_tags)) {
			//List the attributes you want to allow here
			if (is_null($allowed_attrs))
				$allowed_attrs = array ("class", "id", "style");
			if (is_array($allowed_attrs))
				$allowed_attrs = array_flip($allowed_attrs);
		}
		
		if ($allowed_tags !== TRUE || $allowed_attrs !== TRUE) {
			
			$xml = new DOMDocument();
			//Suppress warnings: proper error handling is beyond scope of example
			libxml_use_internal_errors(true);
			
			// Sorry, this gets weird and repetative, it is better than doing the checks in a loop...
			if ($xml->loadHTML("<libxml_container>$html_str</libxml_container>", LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD)) {
				
				if (empty($allowed_tags)) {
					
					// Remove All Tags - with text content, it really just does this once due to there being one root node
					foreach ($xml->getElementsByTagName("*") as $tag)
						$tag->parentNode->replaceChild($xml->createTextNode($tag->textContent), $tag);
					
				} else {
					
					/**
					 * The following ensures that only the SOURCE of the input
					 * string ($html_str) is parsed, handled, and output. If we did
					 * not do this, the DOMDocument would wrap a raw string (no
					 * tags) in an arbitrary tag (<p>) which would muck about with
					 * all our hard work...  Alas.
					 *
					 * @author Michael Mulligan <mike@belineperspectives.com>
					 */
					$container = $xml->getElementsByTagName('libxml_container')->item(0);
					$container = $container->parentNode->removeChild($container);
					
					while ($xml->firstChild)
						$xml->removeChild($xml->firstChild);
					
					while ($container->firstChild )
						$xml->appendChild($container->firstChild);
					
					unset($container);
				
					if ($allowed_tags === TRUE) {
						
						// Allow All Tags
						if (empty($allowed_attrs)) {
						
							// Allow All Tags and Remove All Attributes
							foreach ($xml->getElementsByTagName("*") as $tag)
								foreach ($tag->attributes as $attr)
									$tag->removeAttribute($attr->nodeName);
							
						} else {
						
							// Allow All Tags and Remove Some Attributes
							foreach ($xml->getElementsByTagName("*") as $tag) 
								foreach ($tag->attributes as $attr)
									if (!isset($allowed_attrs[$attr->nodeName]))
										$tag->removeAttribute($attr->nodeName);
							
						}
						
					} elseif ($allowed_attrs === TRUE) {
						
						// Remove Some Tags and Allow All Attributes
						foreach ($xml->getElementsByTagName("*") as $tag)
							if (!isset($allowed_tags[$tag->tagName]))
								$tag->parentNode->replaceChild($xml->createTextNode($tag->textContent), $tag);
						
					} elseif (empty($allowed_attrs)) {
						
						// Remove Some Tags and Remove All Attributes
						foreach ($xml->getElementsByTagName("*") as $tag){
							if (!isset($allowed_tags[$tag->tagName]))
								$tag->parentNode->replaceChild($xml->createTextNode($tag->textContent), $tag);
							else
								foreach ($tag->attributes as $attr)
									$tag->removeAttribute($attr->nodeName);
						}
						
					} else {
						
						// Remove Some Tags and Remove Some Attributes
						foreach ($xml->getElementsByTagName("*") as $tag){
							if (!isset($allowed_tags[$tag->tagName]))
								$tag->parentNode->replaceChild($xml->createTextNode($tag->textContent), $tag);
							else
								foreach ($tag->attributes as $attr)
									if (!isset($allowed_attrs[$attr->nodeName]))
										$tag->removeAttribute($attr->nodeName);
						}
						
					}
					
				}
				
			}
			
			$html_str = $xml->saveHTML();
			
		}
	}
	return (string) $html_str;
}
}
