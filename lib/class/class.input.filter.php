<?php
class clsInputFilter
{
	var $tagsArray;
	var $attrArray;
	var $tagsMethod;
	var $attrMethod;
	var $xssAuto;
	var $tagBlacklist = array(
		'applet',
		'body',
		'bgsound',
		'base',
		'basefont',
		'embed',
		'frame',
		'frameset',
		'head',
		'html',
		'id',
		'iframe',
		'ilayer',
		'layer',
		'link',
		'meta',
		'name',
		'object',
		'script',
		'style',
		'title',
		'xml'
	);
	var $attrBlacklist = array(
		'action',
		'background',
		'codebase',
		'dynsrc',
		'lowsrc'
	);

	function clsInputFilter($tagsArray = array(), $attrArray = array(), $tagsMethod = 0, $attrMethod = 0, $xssAuto = 1)
	{
		$tagsArray = array_map('strtolower', (array) $tagsArray);
		$attrArray = array_map('strtolower', (array) $attrArray);

		$this->tagsArray = $tagsArray;
		$this->attrArray = $attrArray;
		$this->tagsMethod = $tagsMethod;
		$this->attrMethod = $attrMethod;
		$this->xssAuto = $xssAuto;
	}

	function fnClean($src, $type = 'string')
	{
		switch (strtoupper($type))
		{
			case 'INT':
			case 'INTEGER':
				preg_match('/-?[0-9]+/', (string)$src, $matches);
				$result = @(int)$matches[0];
				break;
			case 'UINT':
				preg_match('/-?[0-9]+/', (string)$src, $matches);
				$result = @abs((int)$matches[0]);
				break;
			case 'FLOAT':
			case 'DOUBLE':
				preg_match('/-?[0-9]+(\.[0-9]+)?/', (string)$src, $matches);
				$result = @(float)$matches[0];
				break;
			case 'BOOL':
			case 'BOOLEAN':
				$result = (bool)$src;
				break;
			case 'WORD':
				$result = (string)preg_replace('/[^A-Z_]/i', '', $src);
				break;
			case 'ALNUM':
				$result = (string)preg_replace('/[^A-Z0-9]/i', '', $src);
				break;
			case 'CMD':
				$result = (string)preg_replace('/[^A-Z0-9_\.-]/i', '', $src);
				$result = ltrim($result, '.');
				break;
			case 'BASE64':
				$result = (string)preg_replace('/[^A-Z0-9\/+=]/i', '', $src);
				break;
			case 'STRING':
				$result = (string)$this->_fnRemove($this->_fnDecode((string)$src));
				break;
			case 'HTML':
				$result = (string)$this->_fnRemove((string)$src);
				break;
			case 'ARRAY':
				$result = (array) $src;
				break;
			case 'PATH':
				$pattern = '/^[A-Za-z0-9_-]+[A-Za-z0-9_\.-]*([\\\\\/][A-Za-z0-9_-]+[A-Za-z0-9_\.-]*)*$/';
				preg_match($pattern, (string)$src, $matches);
				$result = @(string)$matches[0];
				break;
			case 'USERNAME':
				$result = (string)preg_replace('/[\x00-\x1F\x7F<>"\'%&]/', '', $src);
				break;
			default:
				if (is_array($src))
				{
					foreach ($src as $key => $value)
					{
						if (is_string($value))
						{
							$src[$key] = $this->_fnRemove($this->_fnDecode($value));
						}
					}
					$result = $src;
				}
				else
				{
					if (is_string($src) && !empty($src))
					{
						$result = $this->_fnRemove($this->_fnDecode($src));
					}
					else
					{
						$result = $src;
					}
				}
				break;
		}
		return $result;
	}

	function _fnDecode($src)
	{
		if (!isset($ttr) || !is_array($ttr))
		{
			$trans_tbl = get_html_translation_table(HTML_ENTITIES);
			foreach ($trans_tbl as $k => $v)
			{
				$ttr[$v] = utf8_encode($k);
			}
		}
		$src = strtr($src, $ttr);
		// 10진수
		$src = preg_replace('/&#(\d+);/me', "utf8_encode(chr(\\1))", $src);
		// 16진수
		$src = preg_replace('/&#x([a-f0-9]+);/mei', "utf8_encode(chr(0x\\1))", $src);
		return $src;
	}

	function _fnRemove($src)
	{
		$loopCounter = 0;

		while ($src != $this->_fnCleanTags($src))
		{
			$src = $this->_fnCleanTags($src);
			$loopCounter++;
		}

		return $src;
	}

	function _fnCleanTags($src)
	{
		$src = $this->_fnEscapeAttributeValues($src);
		$preTag = null;
		$postTag = $src;
		$currentSpace = false;
		$attr = '';
		$tagOpen_start = strpos($src, '<');

		while ($tagOpen_start !== false)
		{
			$preTag .= substr($postTag, 0, $tagOpen_start);
			$postTag = substr($postTag, $tagOpen_start);
			$fromTagOpen = substr($postTag, 1);
			$tagOpen_end = strpos($fromTagOpen, '>');

			$nextOpenTag = (strlen($postTag) > $tagOpen_start) ? strpos($postTag, '<', $tagOpen_start + 1) : false;
			if (($nextOpenTag !== false) && ($nextOpenTag < $tagOpen_end))
			{
				$postTag = substr($postTag, 0, $tagOpen_start) . substr($postTag, $tagOpen_start + 1);
				$tagOpen_start = strpos($postTag, '<');
				continue;
			}//end if

			if ($tagOpen_end === false)
			{
				$postTag = substr($postTag, $tagOpen_start + 1);
				$tagOpen_start = strpos($postTag, '<');
				continue;
			}//end if

			$tagOpen_nested = strpos($fromTagOpen, '<');
			$tagOpen_nested_end = strpos(substr($postTag, $tagOpen_end), '>');
			if (($tagOpen_nested !== false) && ($tagOpen_nested < $tagOpen_end))
			{
				$preTag .= substr($postTag, 0, ($tagOpen_nested + 1));
				$postTag = substr($postTag, ($tagOpen_nested + 1));
				$tagOpen_start = strpos($postTag, '<');
				continue;
			}

			$tagOpen_nested = (strpos($fromTagOpen, '<') + $tagOpen_start + 1);
			$currentTag = substr($fromTagOpen, 0, $tagOpen_end);
			$tagLength = strlen($currentTag);
			$tagLeft = $currentTag;
			$attrSet = array();
			$currentSpace = strpos($tagLeft, ' ');

			if (substr($currentTag, 0, 1) == '/')
			{
				// Close Tag
				$isCloseTag = true;
				list ($tagName) = explode(' ', $currentTag);
				$tagName = substr($tagName, 1);
			}
			else
			{
				// Open Tag
				$isCloseTag = false;
				list ($tagName) = explode(' ', $currentTag);
			}

			if ((!preg_match("/^[a-z][a-z0-9]*$/i", $tagName)) || (!$tagName) || ((in_array(strtolower($tagName), $this->tagBlacklist)) && ($this->xssAuto)))
			{
				$postTag = substr($postTag, ($tagLength + 2));
				$tagOpen_start = strpos($postTag, '<');
				// Strip tag
				continue;
			}

			while ($currentSpace !== false)
			{
				$attr = '';
				$fromSpace = substr($tagLeft, ($currentSpace + 1));
				$nextEqual = strpos($fromSpace, '=');
				$nextSpace = strpos($fromSpace, ' ');
				$openQuotes = strpos($fromSpace, '"');
				$closeQuotes = strpos(substr($fromSpace, ($openQuotes + 1)), '"') + $openQuotes + 1;

				$startAtt = '';
				$startAttPosition = 0;

				if (preg_match('#\s*=\s*\"#', $fromSpace, $matches, PREG_OFFSET_CAPTURE))
				{
					$startAtt = $matches[0][0];
					$startAttPosition = $matches[0][1];
					$closeQuotes = strpos(substr($fromSpace, ($startAttPosition + strlen($startAtt))), '"') + $startAttPosition + strlen($startAtt);
					$nextEqual = $startAttPosition + strpos($startAtt, '=');
					$openQuotes = $startAttPosition + strpos($startAtt, '"');
					$nextSpace = strpos(substr($fromSpace, $closeQuotes), ' ') + $closeQuotes;
				}

				if ($fromSpace != '/' && (($nextEqual && $nextSpace && $nextSpace < $nextEqual) || !$nextEqual))
				{
					if (!$nextEqual)
					{
						$attribEnd = strpos($fromSpace, '/') - 1;
					}
					else
					{
						$attribEnd = $nextSpace - 1;
					}
					if ($attribEnd > 0)
					{
						$fromSpace = substr($fromSpace, $attribEnd + 1);
					}
				}

				if (strpos($fromSpace, '=') !== false)
				{
					if (($openQuotes !== false) && (strpos(substr($fromSpace, ($openQuotes + 1)), '"') !== false))
					{
						$attr = substr($fromSpace, 0, ($closeQuotes + 1));
					}
					else
					{
						$attr = substr($fromSpace, 0, $nextSpace);
					}
				}
				else
				{
					if ($fromSpace != '/')
					{
						$attr = substr($fromSpace, 0, $nextSpace);
					}
				}

				if (!$attr && $fromSpace != '/')
				{
					$attr = $fromSpace;
				}

				$attrSet[] = $attr;

				$tagLeft = substr($fromSpace, strlen($attr));
				$currentSpace = strpos($tagLeft, ' ');
			}//end inner while

			$tagFound = in_array(strtolower($tagName), $this->tagsArray);

			if ((!$tagFound && $this->tagsMethod) || ($tagFound && !$this->tagsMethod))
			{
				if (!$isCloseTag)
				{
					$attrSet = $this->_fnCleanAttributes($attrSet);
					$preTag .= '<' . $tagName;
					for ($i = 0, $count = count($attrSet); $i < $count; $i++)
					{
						$preTag .= ' ' . $attrSet[$i];
					}

					if (strpos($fromTagOpen, '</' . $tagName))
					{
						$preTag .= '>';
					}
					else
					{
						$preTag .= ' />';
					}
				}
				else
				{
					$preTag .= '</' . $tagName . '>';
				}
			}

			$postTag = substr($postTag, ($tagLength + 2));
			$tagOpen_start = strpos($postTag, '<');

		}//end while

		if ($postTag != '<')
		{
			$preTag .= $postTag;
		}

		return $preTag;
	}

	function _fnCleanAttributes($attrSet)
	{
		$newSet = array();
		$count = count($attrSet);

		for ($i = 0; $i < $count; $i++)
		{
			if (!$attrSet[$i])
			{
				continue;
			}

			$attrSubSet = explode('=', trim($attrSet[$i]), 2);
			$attrSubSet[0] = array_pop(explode(' ', trim($attrSubSet[0])));

			if ((!preg_match('/[a-z]*$/i', $attrSubSet[0]))
				|| (($this->xssAuto) && ((in_array(strtolower($attrSubSet[0]), $this->attrBlacklist))
				|| (substr($attrSubSet[0], 0, 2) == 'on'))))
			{
				continue;
			}

			if (isset($attrSubSet[1]))
			{
				$attrSubSet[1] = trim($attrSubSet[1]);
				$attrSubSet[1] = str_replace('&#', '', $attrSubSet[1]);
				$attrSubSet[1] = preg_replace('/[\n\r]/', '', $attrSubSet[1]);
				$attrSubSet[1] = str_replace('"', '', $attrSubSet[1]);

				if ((substr($attrSubSet[1], 0, 1) == "'") && (substr($attrSubSet[1], (strlen($attrSubSet[1]) - 1), 1) == "'"))
				{
					$attrSubSet[1] = substr($attrSubSet[1], 1, (strlen($attrSubSet[1]) - 2));
				}

				$attrSubSet[1] = stripslashes($attrSubSet[1]);
			}
			else
			{
				continue;
			}

			if ($this->fnChkAttribute($attrSubSet))
			{
				continue;
			}

			$attrFound = in_array(strtolower($attrSubSet[0]), $this->attrArray);

			if ((!$attrFound && $this->attrMethod) || ($attrFound && !$this->attrMethod))
			{
				if (empty($attrSubSet[1]) === false)
				{
					$newSet[] = $attrSubSet[0] . '="' . $attrSubSet[1] . '"';
				}
				elseif ($attrSubSet[1] === "0")
				{
					$newSet[] = $attrSubSet[0] . '="0"';
				}
				else
				{
					$newSet[] = $attrSubSet[0] . '=""';
				}
			}
		}

		return $newSet;
	}

	function fnChkAttribute($attrSubSet)
	{
		$attrSubSet[0] = strtolower($attrSubSet[0]);
		$attrSubSet[1] = strtolower($attrSubSet[1]);

		return (((strpos($attrSubSet[1], 'expression') !== false) && ($attrSubSet[0]) == 'style') || (strpos($attrSubSet[1], 'javascript:') !== false) ||
			(strpos($attrSubSet[1], 'behaviour:') !== false) || (strpos($attrSubSet[1], 'vbscript:') !== false) ||
			(strpos($attrSubSet[1], 'mocha:') !== false) || (strpos($attrSubSet[1], 'livescript:') !== false));
	}

	function _fnEscapeAttributeValues($src)
	{
		$alreadyFiltered = '';
		$remainder = $src;
		$badChars = array('<', '"', '>');
		$escapedChars = array('&lt;', '&quot;', '&gt;');

		while (preg_match('#<[^>]*?=\s*?(\"|\')#s', $remainder, $matches, PREG_OFFSET_CAPTURE))
		{
			$quotePosition = $matches[0][1];
			$nextBefore = $quotePosition + strlen($matches[0][0]);

			$quote = substr($matches[0][0], -1);
			$pregMatch = ($quote == '"') ? '#(\"\s*/\s*>|\"\s*>|\"\s+|\"$)#' : "#(\'\s*/\s*>|\'\s*>|\'\s+|\'$)#";

			if (preg_match($pregMatch, substr($remainder, $nextBefore), $matches, PREG_OFFSET_CAPTURE))
			{
				$nextAfter = $nextBefore + $matches[0][1];
			}
			else
			{
				$nextAfter = strlen($remainder);
			}
			$attributeValue = substr($remainder, $nextBefore, $nextAfter - $nextBefore);
			$attributeValue = str_replace($badChars, $escapedChars, $attributeValue);
			$attributeValue = $this->_fnStripCSSExpressions($attributeValue);
			$alreadyFiltered .= substr($remainder, 0, $nextBefore) . $attributeValue . $quote;
			$remainder = substr($remainder, $nextAfter + 1);
		}
		return $alreadyFiltered . $remainder;
	}

	function _fnStripCSSExpressions($src)
	{
		$test = preg_replace('#\/\*.*\*\/#U', '', $src);
		if (!stripos($test, ':expression'))
		{
			$return = $src;
		}
		else
		{
			if (preg_match_all('#:expression\s*\(#', $test, $matches))
			{
				$test = str_ireplace(':expression', '', $test);
				$return = $test;
			}
		}
		return $return;
	}
}
?>