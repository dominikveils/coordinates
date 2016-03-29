<?php

namespace DominikVeils\Geo;

/**
 * Simple geo coordinates help class
 * @package DominikVeils
 */
class Coordinates
{

    const EARTH_DEG_TO_M = 111195.08372419141683547026199257867994858957787746329;
    const EARTH_RADIUS = 6367.4447;

    /**
     * Set of coordinates
     *
     * @param array $coordinates
     */
    public function setCoordinates(array $coordinates)
    {
        $coordinates = $coordinates;
    }

    /**
     * Checks if POINT($sx, $sy) within the coordinates
     *
     * @param integer $sx Latitude
     * @param integer $sy Longitude
     * @param array   $coordinates Coordinates array
     *
     * @return bool
     */
    public function contains($sx, $sy, array $coordinates = [])
    {
        $pj = 0;
        $pk = 0;
        $wrkx = 0;
        $yu = 0;
        $yl = 0;
        $n = count($coordinates);
        for ($pj = 0; $pj < $n; $pj++) {
            $yu = $coordinates[$pj][1] > $coordinates[($pj + 1) % $n][1] ? $coordinates[$pj][1] : $coordinates[($pj + 1) % $n][1];
            $yl = $coordinates[$pj][1] < $coordinates[($pj + 1) % $n][1] ? $coordinates[$pj][1] : $coordinates[($pj + 1) % $n][1];
            if ($coordinates[($pj + 1) % $n][1] - $coordinates[$pj][1]) {
                $wrkx = $coordinates[$pj][0] + ($coordinates[($pj + 1) % $n][0] - $coordinates[$pj][0]) * ($sy - $coordinates[$pj][1]) / ($coordinates[($pj + 1) % $n][1] - $coordinates[$pj][1]);
            } else {
                $wrkx = $coordinates[$pj][0];
            }
            if ($yu >= $sy) {
                if ($yl < $sy) {
                    if ($sx > $wrkx) {
                        $pk++;
                    }
                    if (abs($sx - $wrkx) < 0.00001) {
                        return true;
                    }
                }
            }
            if ((abs($sy - $yl) < 0.00001) && (abs($yu - $yl) < 0.00001) && (abs(abs($wrkx - $coordinates[$pj][0]) + abs($wrkx - $coordinates[($pj + 1) % $n][0]) - abs($coordinates[$pj][0] - $coordinates[($pj + 1) % $n][0])) < 0.0001)) {
                return true;
            }
        }
        if ($pk % 2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Calculates distance between two points(in km)
     *
     * @param array $point1 ['latitude' => 1, 'longitude' => 1]
     * @param array $point2 ['latitude' => 2, 'longitude' => 2]
     *
     * @return float
     */
    public function distance(array $point1, array $point2)
    {
        $dLat = $this->toRadian($point2['latitude'] - $point1['latitude']);
        $dLng = $this->toRadian($point2['longitude'] - $point1['longitude']);

        $lat1 = $this->toRadian($point1['latitude']);
        $lat2 = $this->toRadian($point2['latitude']);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            sin($dLng / 2) * sin($dLng / 2) *
            cos($lat1) * cos($lat2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = static::EARTH_RADIUS * $c;

        return (int)round($d, 0);
    }

    /**
     * Convert point value to radians
     *
     * @param $value
     *
     * return float
     */
    public function toRadian($value)
    {
        return $value * (M_PI / 180);
    }
}
