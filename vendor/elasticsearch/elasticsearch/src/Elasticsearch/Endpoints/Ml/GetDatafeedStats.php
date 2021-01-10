<?php
/**
 * Elasticsearch PHP client
 *
 * @link      https://github.com/elastic/elasticsearch-php/
 * @copyright Copyright (c) Elasticsearch B.V (https://www.elastic.co)
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license   https://www.gnu.org/licenses/lgpl-2.1.html GNU Lesser General Public License, Version 2.1 
 * 
 * Licensed to Elasticsearch B.V under one or more agreements.
 * Elasticsearch B.V licenses this file to you under the Apache 2.0 License or
 * the GNU Lesser General Public License, Version 2.1, at your option.
 * See the LICENSE file in the project root for more information.
 */
declare(strict_types = 1);

namespace Elasticsearch\Endpoints\Ml;

use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 * Class GetDatafeedStats
 * Elasticsearch API name ml.get_datafeed_stats
 *
 * NOTE: this file is autogenerated using util/GenerateEndpoints.php
 * and Elasticsearch 7.11.0-SNAPSHOT (8513510881a3f759492a3a6c62eefeee932dfe64)
 */
class GetDatafeedStats extends AbstractEndpoint
{
    protected $datafeed_id;

    public function getURI(): string
    {
        $datafeed_id = $this->datafeed_id ?? null;

        if (isset($datafeed_id)) {
            return "/_ml/datafeeds/$datafeed_id/_stats";
        }
        return "/_ml/datafeeds/_stats";
    }

    public function getParamWhitelist(): array
    {
        return [
            'allow_no_match',
            'allow_no_datafeeds'
        ];
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    public function setDatafeedId($datafeed_id): GetDatafeedStats
    {
        if (isset($datafeed_id) !== true) {
            return $this;
        }
        $this->datafeed_id = $datafeed_id;

        return $this;
    }
}
