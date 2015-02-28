<?php
/*
 * This function starts out with several checks in an attempt to save time.
 *   1.  The shorter string is always used as the "right-hand" string (as the size of the array is based on its length).
 *   2.  If the left string is empty, the length of the right is returned.
 *   3.  If the right string is empty, the length of the left is returned.
 *   4.  If the strings are equal, a zero-distance is returned.
 *   5.  If the left string is contained within the right string, the difference in length is returned.
 *   6.  If the right string is contained within the left string, the difference in length is returned.
 * If none of the above conditions were met, the Levenshtein algorithm is used.
 */



function LevenshteinDistance($s1, $s2)
 {
   $sLeft = (strlen($s1) > strlen($s2)) ? $s1 : $s2;
   $sRight = (strlen($s1) > strlen($s2)) ? $s2 : $s1;
   $nLeftLength = strlen($sLeft);
   $nRightLength = strlen($sRight);
   if ($nLeftLength == 0)
     return $nRightLength;
   else if ($nRightLength == 0)
     return $nLeftLength;
   else if ($sLeft === $sRight)
     return 0;
   else if (($nLeftLength < $nRightLength) && (strpos($sRight, $sLeft) !== FALSE))
     return $nRightLength - $nLeftLength;
   else if (($nRightLength < $nLeftLength) && (strpos($sLeft, $sRight) !== FALSE))
     return $nLeftLength - $nRightLength;
   else {
     $nsDistance = range(1, $nRightLength + 1);
     for ($nLeftPos = 1; $nLeftPos <= $nLeftLength; ++$nLeftPos)
     {
       $cLeft = $sLeft[$nLeftPos - 1];
       $nDiagonal = $nLeftPos - 1;
       $nsDistance[0] = $nLeftPos;
       for ($nRightPos = 1; $nRightPos <= $nRightLength; ++$nRightPos)
       {
         $cRight = $sRight[$nRightPos - 1];
         $nCost = ($cRight == $cLeft) ? 0 : 1;
         $nNewDiagonal = $nsDistance[$nRightPos];
         $nsDistance[$nRightPos] =
           min($nsDistance[$nRightPos] + 1,
               $nsDistance[$nRightPos - 1] + 1,
               $nDiagonal + $nCost);
         $nDiagonal = $nNewDiagonal;
       }
     }
     return $nsDistance[$nRightLength];
   }
 }



?>