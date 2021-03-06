<?php 
/** 

RIPS - A static source code analyser for vulnerabilities in PHP scripts 
	by Johannes Dahse (johannesdahse@gmx.de)
			
			
Copyright (C) 2010 Johannes Dahse

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>.	

**/

	function searchFile($file_name, $search)
	{
		$search = str_replace('/', '\/', $search);
		$lines = file($file_name);
		$block = new VulnBlock('Search hits');
		for($i=0; $i<count($lines); $i++)
	 	{
			if(preg_match("/".trim($search)."/i", $lines[$i]))
			{
				$GLOBALS['count_matches']++;
				
				$line = highlightline($lines[$i], $i+1, $search);
				$line = preg_replace("/(".trim($search).")/i", "<span class='markline'>$1</span>", $line);
				$new_find = new VulnTreeNode($line);
				$new_find->title = 'Regular expression match';
				$new_find->lines[] = $i+1;
					
				$block->treenodes[] = $new_find;	
				$block->vuln = true;	
			}
		}
		$id = (isset($GLOBALS['output'][$file_name])) ? count($GLOBALS['output'][$file_name]) : 0;
		$GLOBALS['output'][$file_name][$id] = $block;
	}
	
?> 