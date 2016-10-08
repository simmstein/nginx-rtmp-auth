<?php

namespace Deblan\Bundle\RtmpBundle\AuthProvider;

use Symfony\Component\HttpFoundation\Request;
use Deblan\Bundle\RtmpBundle\Model\StreamQuery;
use Deblan\Bundle\RtmpBundle\Model\AccountQuery;

/**
 * Class PropelAuthProvider.
 *
 * @author Simon Vieille <simon@deblan.fr>
 */
class PropelAuthProvider implements AuthProvider
{
    /**
     * @var string
     */
    protected $host;
    
    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $name;

    
    /**
     * @param string $host
     *
     * @return __CLASS__
     */
    public function setHost($host)
    {
        $this->host = (string) $host;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $path
     *
     * @return __CLASS__
     */
    public function setPath($path)
    {
        $this->path = (string) $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $name
     *
     * @return PropelAuthProvider
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $key
     *
     * @return PropelAuthProvider
     */
    public function setKey($key)
    {
        $this->key = (string) $key;

        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Handles a request
     *
     * @param Request $request
     *
     * @return PropelAuthProvider
     */
    public function handleRequest(Request $request)
    {
        $bag = $request->isMethod('post') ? $request->request : $request->query;

        $this->setName($bag->get('name'));

        $parse = parse_url($bag->get('swfurl'));

        if (!empty($parse['host'])) {
            $this->setHost($parse['host']);
        }

        if (!empty($parse['path'])) {
            $this->setPath($parse['path']);
        }

        if (!empty($parse['query'])) {
            $regex = '/key=([^&]+)/';
            preg_match($regex, $parse['query'], $match);

            if (!empty($match[1])) {
                $this->setKey($match[1]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
        $accounts = AccountQuery::create()
            ->filterByChannel($this->getName())
            ->filterByKey($this->getKey())
            ->find();

        if ($accounts->count() === 0) {
            return false;
        }

        $stream = StreamQuery::create()
            ->filterByHost($this->getHost())
            ->filterByPath($this->getPath())
            ->findOne();

        if ($stream === null) {
            return false;
        }

        foreach ($accounts as $account) {
            if ($account->getStreams()->contains($stream)) {
                return true;
            }
        }

        return false;
    }
}
