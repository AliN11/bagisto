<?php

namespace Webkul\Shop\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Webkul\Core\Repositories\SliderRepository as Sliders;
use Webkul\Channel\Channel as Channel;
/**
 * Admin user session controller
 *
 * @author    Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class HomeController extends controller
{
    protected $_config;
    protected $sliders;
    protected $current_channel;

    public function __construct(Sliders $s,Channel $c)
    {
        $this->_config = request('_config');
        $this->sliders = $s;
        $this->current_channel = $c;

    }
    public function index() {

        $current_channel = $this->current_channel->getCurrentChannel();

        $all_sliders = $this->sliders->findWhere(['channel_id'=>$current_channel['id']]);

        return view($this->_config['view'])->with('data',$all_sliders);
    }
}