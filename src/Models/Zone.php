<?php

/*
 * This file is part of Laravel CloudFlare API.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\CloudFlareAPI\Models;

use GuzzleHttp\Command\Guzzle\GuzzleClient;
use Illuminate\Support\Collection;

/**
 * This is the zone model class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class Zone extends AbstractModel
{
    /**
     * The zone name.
     *
     * @var string
     */
    protected $zone;

    /**
     * Create a new model instance.
     *
     * @param \GuzzleHttp\Command\Guzzle\GuzzleClient $client
     * @param string                                  $zone
     * @param array                                   $cache
     *
     * @return void
     */
    public function __construct(GuzzleClient $client, $zone, array $cache = [])
    {
        parent::__construct($client, $cache);

        $this->zone = (string) $zone;
    }

    /**
     * Get the zone name.
     *
     * @return string
     */
    public function getZone()
    {
        return (string) $this->zone;
    }

    /**
     * Get the traffic information.
     *
     * @param int $time
     *
     * @return array
     */
    public function getTraffic($time = 20)
    {
        return (array) $this->stat($time, 'trafficBreakdown');
    }

    /**
     * Get the bandwidth information.
     *
     * @param int $time
     *
     * @return array
     */
    public function getBandwidth($time = 20)
    {
        return (array) $this->stat($time, 'bandwidthServed');
    }

    /**
     * Get the requests information.
     *
     * @param int $time
     *
     * @return array
     */
    public function getRequests($time = 20)
    {
        return (array) $this->stat($time, 'requestsServed');
    }

    /**
     * Get the user security level.
     *
     * @return string
     */
    public function getUserSecurity()
    {
        return (string) $this->setting('userSecuritySetting');
    }

    /**
     * Is in dev mode?
     *
     * @return bool
     */
    public function isInDevMode()
    {
        return (bool) $this->setting('dev_mode');
    }

    /**
     * Get the supported ip versions.
     *
     * @return int
     */
    public function getIpVersions()
    {
        return (int) $this->setting('ipv46');
    }

    /**
     * Is always online enabled?
     *
     * @return bool
     */
    public function isAlwaysOnline()
    {
        return (bool) $this->setting('ob');
    }

    /**
     * Get the cache level.
     *
     * @return string
     */
    public function getCacheLevel()
    {
        return (string) $this->setting('cache_lvl');
    }

    /**
     * Is outbound linking analysis enabled?
     *
     * @return bool
     */
    public function isOutboundinking()
    {
        return (bool) ($this->setting('outboundLinks') != 'disabled');
    }

    /**
     * Get the rocket loader level.
     *
     * @return string
     */
    public function getRocketLoader()
    {
        return (string) $this->setting('async');
    }

    /**
     * Is browser checking enabled?
     *
     * @return bool
     */
    public function isBrowserChecking()
    {
        return (bool) $this->setting('bic');
    }

    /**
     * Get the challenge page's time to live.
     *
     * @return int
     */
    public function getChallengeTtl()
    {
        return (int) $this->setting('chl_ttl');
    }

    /**
     * Get the cached items' time to live.
     *
     * @return int
     */
    public function getExpireTtl()
    {
        return (int) $this->setting('exp_ttl');
    }

    /**
     * Is hot linking protection enabled?
     *
     * @return bool
     */
    public function isHotlinkingProtected()
    {
        return (bool) $this->setting('hotlink');
    }

    /**
     * Get auto-resizing configuration.
     *
     * @return int
     */
    public function getAutoResizing()
    {
        return (int) $this->setting('img');
    }

    /**
     * Is lazy loading enabled?
     *
     * @return bool
     */
    public function isLazyLoading()
    {
        return (bool) $this->setting('lazy');
    }

    /**
     * Get the minification level.
     *
     * @return int
     */
    public function getMinification()
    {
        return (int) $this->setting('minify');
    }

    /**
     * Is pre-loading enabled?
     *
     * @return bool
     */
    public function isPreloading()
    {
        return (bool) $this->setting('preload');
    }

    /**
     * Are smart errors enabled?
     *
     * @return bool
     */
    public function areErrorsSmart()
    {
        return (bool) $this->setting('s404');
    }

    /**
     * Get security level.
     *
     * @return string
     */
    public function getSecurityLevel()
    {
        return (string) $this->setting('sec_lvl');
    }

    /**
     * Is spdy enabled?
     *
     * @return bool
     */
    public function isSpdy()
    {
        return (bool) $this->setting('spdy');
    }

    /**
     * Get ssl level.
     *
     * @return int
     */
    public function getSsl()
    {
        return (int) $this->setting('ssl');
    }

    /**
     * Get web application firewall profile.
     *
     * @return string
     */
    public function getWafProfile()
    {
        return (string) $this->setting('waf_profile');
    }

    /**
     * Set the security level.
     *
     * @param string $level
     *
     * @return $this
     */
    public function setSecurityLevel($level)
    {
        $this->action('secLvl', ['v' => $level], 'zoneSettings');

        return $this;
    }

    /**
     * Set the cache level.
     *
     * @param string $level
     *
     * @return $this
     */
    public function setCacheLevel($level)
    {
        $this->action('cacheLvl', ['v' => $level], 'zoneSettings');

        return $this;
    }

    /**
     * Enable dev mode.
     *
     * @return $this
     */
    public function enableDevMode()
    {
        $this->action('devMode', ['v' => 1], 'zoneSettings');

        return $this;
    }

    /**
     * Disable dev mode.
     *
     * @return $this
     */
    public function disableDevMode()
    {
        $this->action('devMode', ['v' => 0], 'zoneSettings');

        return $this;
    }

    /**
     * Purge all entries from the cloudflare cache.
     *
     * @return $this
     */
    public function purgeAll()
    {
        $this->action('fpurgeTs', ['v' => 1], false);

        return $this;
    }

    /**
     * Purge a single url from the cloudflare cache.
     *
     * @param string $url
     *
     * @return $this
     */
    public function purgeUrl($url)
    {
        $this->action('zoneFilePurge', ['url' => $url], false);

        return $this;
    }

    /**
     * Purge multiple urls from the cloudflare cache.
     *
     * @param string[] $urls
     *
     * @return $this
     */
    public function purgeUrls(array $urls)
    {
        foreach ($urls as $url) {
            $this->purgeUrl($url);
        }

        return $this;
    }

    /**
     * Updated the site snapshot on the challenge page.
     *
     * @return $this
     */
    public function updateSnapshot()
    {
        $zoneSettings = $this->get('zoneCheck', ['zones' => $this->zone]);

        $zid = (int) array_get($zoneSettings, 'response.zones')[$this->zone];

        $this->action('zoneGrab', ['zid' => $zid], false);

        return $this;
    }

    /**
     * Set the supported the ip versions.
     *
     * @param int $versions
     *
     * @return $this
     */
    public function setIpVersions($versions)
    {
        $this->action('ipv46', ['v' => $versions], 'zoneSettings');

        return $this;
    }

    /**
     * Set the rocket loader level.
     *
     * @param string $level
     *
     * @return $this
     */
    public function setRocketLoader($level)
    {
        $this->action('async', ['v' => $level], 'zoneSettings');

        return $this;
    }

    /**
     * Set the minification level.
     *
     * @param int $level
     *
     * @return $this
     */
    public function setMinification($level)
    {
        $this->action('minify', ['v' => $level], 'zoneSettings');

        return $this;
    }

    /**
     * Enable mirage2.
     *
     * @return $this
     */
    public function enableMirage()
    {
        $this->action('mirage', ['v' => 1], 'zoneSettings');

        return $this;
    }

    /**
     * Disable mirage2.
     *
     * @return $this
     */
    public function disableMirage()
    {
        $this->action('mirage', ['v' => 0], 'zoneSettings');

        return $this;
    }

    /**
     * Get all ips as a collection of models.
     *
     * @param int         $hours
     * @param string|null $class
     *
     * @return \Illuminate\Support\Collection
     */
    public function ips($hours = 24, $class = null)
    {
        $zoneIps = $this->get('zoneIps', $this->data(compact('hours', 'class')), $hours.$class);

        $ips = array_get($zoneIps, 'response.ips');

        $all = new Collection();

        foreach ($ips as $ip) {
            $name = $ip['ip'];
            $zoneIp = new ZoneIP($this->client, $name, $this, ['zoneIp' => $ip]);
            $all->put($name, $zoneIp);
        }

        return $all;
    }

    /**
     * Get an ip as a model.
     *
     * @param string      $address
     * @param int         $hours
     * @param string|null $class
     *
     * @return \GrahamCampbell\CloudFlareAPI\Models\ZoneIp
     */
    public function ip($address, $hours = 24, $class = null)
    {
        $zoneIps = $this->get('zoneIps', $this->data(compact('hours', 'class')), $hours.$class);

        $ips = array_get($zoneIps, 'response.ips');

        foreach ($ips as $ip) {
            if ($ip['ip'] == $address) {
                return new ZoneIP($this->client, $address, $this, ['zoneIp' => $ip]);
            }
        }
    }

    /**
     * Get all dns records as a collection of models.
     *
     * @return \Illuminate\Support\Collection
     */
    public function records()
    {
        $recs = $this->get('recLoadAll');

        $records = array_get($recs, 'response.recs.objs');

        $all = new Collection();

        foreach ($records as $record) {
            $id = (int) $record['rec_id'];
            $model = new Record($this->client, $id, $this, ['recLoad' => $record]);
            $all->put($id, $model);
        }

        return $all;
    }

    /**
     * Get a dns record as a model.
     *
     * @param int $id
     *
     * @return \GrahamCampbell\CloudFlareAPI\Models\Record
     */
    public function record($id)
    {
        $recs = $this->get('recLoadAll');

        $records = array_get($recs, 'response.recs.objs');

        foreach ($records as $record) {
            if ((int) $record['rec_id'] === (int) $id) {
                return new Record($this->client, (int) $id, $this, ['recLoad' => $record]);
            }
        }
    }

    /**
     * Create a new record.
     *
     * @param array $data
     *
     * @return $this
     */
    public function createRecord(array $data)
    {
        $this->action('recNew', $data, 'recLoadAll');

        return $this;
    }

    /**
     * Clear all dns record caches.
     *
     * This function will be automatically called by the record model whenever
     * it is updated. This method is not intended for public use.
     *
     * @return $this
     */
    public function clearRecordCache()
    {
        return $this->clearCache('recLoadAll');
    }

    /**
     * Lookup a statistic.
     *
     * @param int    $time
     * @param string $name
     *
     * @return array
     */
    protected function stat($time, $name)
    {
        $stats = $this->get('stats', ['interval' => $time], (string) $time);

        return array_get($stats, 'response.result.objs.0.'.$name);
    }

    /**
     * Lookup a setting.
     *
     * @param string $name
     *
     * @return mixed
     */
    protected function setting($name)
    {
        $zoneSettings = $this->get('zoneSettings');

        return array_get($zoneSettings, 'response.result.objs.0.'.$name);
    }

    /**
     * Get the data to make a request.
     *
     * @param array $data
     *
     * @return array
     */
    protected function data(array $data = [])
    {
        return array_merge(['z' => $this->zone], $data);
    }
}
