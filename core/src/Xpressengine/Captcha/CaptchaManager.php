<?php
/**
 * This file is captcha manager.
 *
 * PHP version 5
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Captcha;

use Illuminate\Support\Manager;

/**
 * # CaptchaManager
 *
 * 사용할 captcha 객체를 제공해 줌.
 *
 * ### app binding : xe.captcha 로 바인딩 되어 있음
 * `Captcha` Facade 로 접근 가능
 *
 * ### Usage
 * * front 에 작성
 * ```html
 * <div>
 *  <?php echo Captcha::render(); ?>
 * </div>
 * ```
 *
 * * 검증 처리
 * ```php
 * if (Captcha::verify() === true) {
 *      // 성공 처리 코드
 * } else {
 *      $errors = Captcha::errors();
 * }
 * ```
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class CaptchaManager extends Manager
{
    /**
     * Create google reCAPTCHA driver
     *
     * @return GoogleReCaptcha
     */
    public function createGoogleDriver()
    {
        $config = $this->getConfig('google');

        return new GoogleRecaptcha(
            $config['siteKey'],
            $config['secret'],
            $this->app['request'],
            $this->app['xe.frontend']
        );
    }

    /**
     * Returns api config
     *
     * @param string $driver driver name
     * @return array
     */
    protected function getConfig($driver)
    {
        $apis = $this->app['config']['captcha.apis'];

        return $apis[$driver];
    }

    /**
     * Get the default captcha driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['captcha.driver'];
    }

    /**
     * Set the default captcha driver name.
     *
     * @param string $name driver name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->app['config']['captcha.driver'] = $name;
    }
}
