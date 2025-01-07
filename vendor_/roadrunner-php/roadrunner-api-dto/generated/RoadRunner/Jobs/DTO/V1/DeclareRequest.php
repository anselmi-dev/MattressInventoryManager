<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# NO CHECKED-IN PROTOBUF GENCODE
# source: jobs/v1/jobs.proto

namespace RoadRunner\Jobs\DTO\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * ---------------------------------------------
 * DeclareRequest used to dynamically declare pipeline -> Declare(req *jobsProto.DeclareRequest, _ *jobsProto.Empty)
 * response `message Empty`
 *
 * Generated from protobuf message <code>jobs.v1.DeclareRequest</code>
 */
class DeclareRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>map<string, string> pipeline = 1;</code>
     */
    private $pipeline;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array|\Google\Protobuf\Internal\MapField $pipeline
     * }
     */
    public function __construct($data = NULL) {
        \RoadRunner\Jobs\DTO\V1\GPBMetadata\Jobs::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>map<string, string> pipeline = 1;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getPipeline()
    {
        return $this->pipeline;
    }

    /**
     * Generated from protobuf field <code>map<string, string> pipeline = 1;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setPipeline($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->pipeline = $arr;

        return $this;
    }

}

