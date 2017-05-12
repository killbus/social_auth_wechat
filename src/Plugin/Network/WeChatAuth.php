<?php

namespace Drupal\social_auth_wechat\Plugin\Network;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Render\MetadataBubblingUrlGenerator;
use Drupal\social_api\SocialApiException;
use Drupal\social_auth\Plugin\Network\SocialAuthNetwork;
use Symfony\Component\DependencyInjection\ContainerInterface;
use EasyWeChat\Foundation\Application;

/**
 * Defines Social Auth Google Network Plugin.
 *
 * This is the main definition of the Network Plugin. The most important
 * properties are listed below.
 *
 * id: The unique identifier of this Network Plugin. It must have the same name
 * as the module itself.
 *
 * social_network: The Social Network for which this Network Plugin is defined.
 *
 * type: The type of the Network Plugin:
 * - social_auth: A Network Plugin for user login/registration.
 * - social_post: A Network Plugin for autoposting tasks.
 * - social_widgets: A Network Plugin for social networks' widgets.
 *
 * handlers: Defined the settings manager and the configuration identifier
 * in the configuration manager. In detail:
 *
 * - settings: The settings management for this Network Plugin.
 *   - class: The class for getting the configuration data. The settings
 *     property of this class is the instance of the class declared in this
 *     field.
 *   - config_id: The configuration id. It usually is the same used by the
 *     configuration form.
 *     @see Drupal\social_auth_wechat\Form\WeChatAuthSettingsForm.
 *
 * @Network(
 *   id = "social_auth_wechat",
 *   social_network = "WeChat",
 *   type = "social_auth",
 *   handlers = {
 *      "settings": {
 *          "class": "\Drupal\social_auth_wechat\Settings\WeChatAuthSettings",
 *          "config_id": "social_auth_wechat.settings"
 *      }
 *   }
 * )
 */
class WeChatAuth extends SocialAuthNetwork {
  /**
   * The url generator.
   *
   * @var \Drupal\Core\Render\MetadataBubblingUrlGenerator
   */
  protected $urlGenerator;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $container->get('url_generator'),
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('config.factory')
    );
  }

  /**
   * GoogleLogin constructor.
   *
   * @param \Drupal\Core\Render\MetadataBubblingUrlGenerator $url_generator
   *   Used to generate a absolute url for authentication.
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   */
  public function __construct(MetadataBubblingUrlGenerator $url_generator, array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $entity_type_manager, $config_factory);

    $this->urlGenerator = $url_generator;
  }

  /**
   * {@inheritdoc}
   *
   * Initializes the WeChat SDK to request WeChat Accounts.
   *
   * The returning value of this method is what is returned when an instance of
   * this Network Plugin called the getSdk method.
   * @see Drupal\social_auth_wechat\Controller\WeChatAuthController::callback
   */
  public function initSdk() {
    // Checks if the dependency, the \EasyWeChat\Foundation\Application library, is available.
    $class_name = '\EasyWeChat\Foundation\Application';
    if (!class_exists($class_name)) {
      throw new SocialApiException(sprintf('The PHP SDK for WeChat Services could not be found. Class: %s.', $class_name));
    }

    /* @var \Drupal\social_auth_wechat\Settings\WeChatAuthSettings $settings */
    /*
     * The settings property is an instance of the class defined in the
     * Network Plugin definition.
     */
    $settings = $this->settings;

    // Gets the absolute url of the callback.
    $redirect_uri = $this->urlGenerator->generateFromRoute('social_auth_wechat.callback', array(), array('absolute' => TRUE));

    // Creates a and sets data to Application object.
    $config = [
      'app_id' => $settings->getClientId(),
      'secret' => $settings->getClientSecret(),
      'oauth' => [
        'scopes'   => [$settings->getClientScope()],
        'callback' => $redirect_uri,
      ],
    ];

    $app = new Application($config);

    /** @var \Overtrue\Socialite\Providers\WeChatProvider $client */
    $client = $app->oauth;

    return $client;
  }

}
