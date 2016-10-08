<?php

namespace Deblan\Bundle\RtmpBundle\AuthProvider;

/**
 * Class AuthProvider
 * @author Simon Vieille <simon@deblan.fr>
 */
interface AuthProvider
{
    /**
     * Returns the authentication validity
     *
     * @return bool
     */
    public function isValid();
}
