<?php

namespace Drupal\social_auth_wechat;

use Symfony\Component\HttpFoundation\RequestStack;
use Overtrue\Socialite\Providers\WeChatProvider;

/**
 * Manages the authentication requests.
 */
class WeChatAuthManager {

  /**
   * The request object.
   *
   * @var \Symfony\Component\HttpFoundation\Request
   */
  private $request;

  /**
   * The WeChat OAuth client.
   *
   * @var \Overtrue\Socialite\Providers\WeChatProvider
   */
  private $client;

  /**
   * WeChatLoginManager constructor.
   *
   * @param \Symfony\Component\HttpFoundation\RequestStack $request
   *   Used to get the parameter code returned by WeChat.
   */
  public function __construct(RequestStack $request) {
    $this->request = $request->getCurrentRequest();
  }

  /**
   * Sets the client object.
   *
   * @param \Overtrue\Socialite\Providers\WeChatProvider $client
   *   WeChat OAuth Client object.
   *
   * @return $this
   *   The current object.
   */
  public function setClient(WeChatProvider $client) {
    $this->client = $client;
    return $this;
  }

  /**
   * Gets the client object.
   *
   * @return \Overtrue\Socialite\Providers\WeChatProvider.
   *   The WeChat Client object.
   */
  public function getClient() {
    return $this->client;
  }

  /**
   * Returns the user information.
   *
   * @return \Overtrue\Socialite\User.
   */
  public function getUserInfo() {
    return $this->client->user();
  }

}
