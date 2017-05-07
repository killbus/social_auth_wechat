<?php

namespace Drupal\social_auth_example\Settings;

/**
 * Defines an interface for Social Auth Google settings.
 */
interface WeChatAuthSettingsInterface {

  /**
   * Gets the client ID.
   *
   * @return string
   *   The client ID.
   */
  public function getClientId();

  /**
   * Gets the client secret.
   *
   * @return string
   *   The client secret.
   */
  public function getClientSecret();

}
