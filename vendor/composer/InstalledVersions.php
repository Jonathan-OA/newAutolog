<?php











namespace Composer;

use Composer\Autoload\ClassLoader;
use Composer\Semver\VersionParser;






class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => 'dev-master',
    'version' => 'dev-master',
    'aliases' => 
    array (
    ),
    'reference' => '4f711b9e114f255e3d56ebf37fc74c9a07063b66',
    'name' => 'laravel/laravel',
  ),
  'versions' => 
  array (
    'aws/aws-sdk-php' => 
    array (
      'pretty_version' => '3.173.27',
      'version' => '3.173.27.0',
      'aliases' => 
      array (
      ),
      'reference' => '80d9e123864834779bf532c1fe3b5923483df835',
    ),
    'cordoval/hamcrest-php' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'davedevelopment/hamcrest-php' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'dnoegel/php-xdg-base-dir' => 
    array (
      'pretty_version' => 'v0.1.1',
      'version' => '0.1.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '8f8a6e48c5ecb0f991c2fdcf5f154a47d85f9ffd',
    ),
    'doctrine/cache' => 
    array (
      'pretty_version' => '1.10.2',
      'version' => '1.10.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '13e3381b25847283a91948d04640543941309727',
    ),
    'doctrine/dbal' => 
    array (
      'pretty_version' => '2.10.3',
      'version' => '2.10.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '03ca23afc2ee062f5d3e32426ad37c34a4770dcf',
    ),
    'doctrine/event-manager' => 
    array (
      'pretty_version' => '1.1.1',
      'version' => '1.1.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '41370af6a30faa9dc0368c4a6814d596e81aba7f',
    ),
    'doctrine/inflector' => 
    array (
      'pretty_version' => '2.0.3',
      'version' => '2.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '9cf661f4eb38f7c881cac67c75ea9b00bf97b210',
    ),
    'doctrine/instantiator' => 
    array (
      'pretty_version' => '1.3.1',
      'version' => '1.3.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f350df0268e904597e3bd9c4685c53e0e333feea',
    ),
    'doctrine/lexer' => 
    array (
      'pretty_version' => '1.2.1',
      'version' => '1.2.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e864bbf5904cb8f5bb334f99209b48018522f042',
    ),
    'dragonmantank/cron-expression' => 
    array (
      'pretty_version' => 'v2.3.0',
      'version' => '2.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '72b6fbf76adb3cf5bc0db68559b33d41219aba27',
    ),
    'egulias/email-validator' => 
    array (
      'pretty_version' => '2.1.19',
      'version' => '2.1.19.0',
      'aliases' => 
      array (
      ),
      'reference' => '840d5603eb84cc81a6a0382adac3293e57c1c64c',
    ),
    'fideloper/proxy' => 
    array (
      'pretty_version' => '4.4.0',
      'version' => '4.4.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '9beebf48a1c344ed67c1d36bb1b8709db7c3c1a8',
    ),
    'filp/whoops' => 
    array (
      'pretty_version' => '2.7.3',
      'version' => '2.7.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '5d5fe9bb3d656b514d455645b3addc5f7ba7714d',
    ),
    'fzaninotto/faker' => 
    array (
      'pretty_version' => 'v1.9.1',
      'version' => '1.9.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'fc10d778e4b84d5bd315dad194661e091d307c6f',
    ),
    'guzzlehttp/guzzle' => 
    array (
      'pretty_version' => '7.2.0',
      'version' => '7.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '0aa74dfb41ae110835923ef10a9d803a22d50e79',
    ),
    'guzzlehttp/promises' => 
    array (
      'pretty_version' => '1.4.1',
      'version' => '1.4.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '8e7d04f1f6450fef59366c399cfad4b9383aa30d',
    ),
    'guzzlehttp/psr7' => 
    array (
      'pretty_version' => '1.7.0',
      'version' => '1.7.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '53330f47520498c0ae1f61f7e2c90f55690c06a3',
    ),
    'hamcrest/hamcrest-php' => 
    array (
      'pretty_version' => 'v2.0.1',
      'version' => '2.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '8c3d0a3f6af734494ad8f6fbbee0ba92422859f3',
    ),
    'illuminate/auth' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/broadcasting' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/bus' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/cache' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/config' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/console' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/container' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/contracts' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/cookie' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/database' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/encryption' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/events' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/filesystem' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/hashing' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/http' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/log' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/mail' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/notifications' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/pagination' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/pipeline' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/queue' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/redis' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/routing' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/session' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/support' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/translation' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/validation' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'illuminate/view' => 
    array (
      'replaced' => 
      array (
        0 => 'v6.18.38',
      ),
    ),
    'infyomlabs/adminlte-templates' => 
    array (
      'pretty_version' => '6.0.x-dev',
      'version' => '6.0.9999999.9999999-dev',
      'aliases' => 
      array (
      ),
      'reference' => '3720be9273bc4b0665a57216bef3c17ad6daefbf',
    ),
    'infyomlabs/laravel-generator' => 
    array (
      'pretty_version' => '6.0.x-dev',
      'version' => '6.0.9999999.9999999-dev',
      'aliases' => 
      array (
      ),
      'reference' => 'b9d0a066c3f4f5e1c3f9da88e5a48cd721636e8e',
    ),
    'jakub-onderka/php-console-color' => 
    array (
      'pretty_version' => 'v0.2',
      'version' => '0.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd5deaecff52a0d61ccb613bb3804088da0307191',
    ),
    'jakub-onderka/php-console-highlighter' => 
    array (
      'pretty_version' => 'v0.4',
      'version' => '0.4.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '9f7a229a69d52506914b4bc61bfdb199d90c5547',
    ),
    'kodeine/laravel-acl' => 
    array (
      'pretty_version' => '2.0.5',
      'version' => '2.0.5.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e428103da352d19b8b670308b9d5103aaf40ad82',
    ),
    'kodova/hamcrest-php' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'laracasts/flash' => 
    array (
      'pretty_version' => '3.1',
      'version' => '3.1.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '150d4348477db31b9a93ccd07f713e3d0513b3bf',
    ),
    'laravel/framework' => 
    array (
      'pretty_version' => 'v6.18.38',
      'version' => '6.18.38.0',
      'aliases' => 
      array (
      ),
      'reference' => '94a29cadcc0d48b89b4aa820f414fb7721ba0e22',
    ),
    'laravel/helpers' => 
    array (
      'pretty_version' => 'v1.3.0',
      'version' => '1.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b4b8d6e84a6306fc88870f61a244d8c537779f2d',
    ),
    'laravel/laravel' => 
    array (
      'pretty_version' => 'dev-master',
      'version' => 'dev-master',
      'aliases' => 
      array (
      ),
      'reference' => '4f711b9e114f255e3d56ebf37fc74c9a07063b66',
    ),
    'laravel/tinker' => 
    array (
      'pretty_version' => 'v1.0.10',
      'version' => '1.0.10.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ad571aacbac1539c30d480908f9d0c9614eaf1a7',
    ),
    'laravelcollective/html' => 
    array (
      'pretty_version' => 'v6.0.3',
      'version' => '6.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'bcc317d21a7e04eebcc81c4109fa84feaab63590',
    ),
    'laravie/parser' => 
    array (
      'pretty_version' => 'v2.1.1',
      'version' => '2.1.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c18873561a4b44bd52c7601f77ca45fe4b944007',
    ),
    'lavary/laravel-menu' => 
    array (
      'pretty_version' => 'v1.7.7',
      'version' => '1.7.7.0',
      'aliases' => 
      array (
      ),
      'reference' => '5592778b3193ae561614ecb107467469b694ab11',
    ),
    'lavela/phpjasper' => 
    array (
      'pretty_version' => 'v3.0',
      'version' => '3.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd3d7bbc7d1d78766dd5c554189ba1680b9b0517a',
    ),
    'league/commonmark' => 
    array (
      'pretty_version' => '1.5.4',
      'version' => '1.5.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '21819c989e69bab07e933866ad30c7e3f32984ba',
    ),
    'league/flysystem' => 
    array (
      'pretty_version' => '1.0.70',
      'version' => '1.0.70.0',
      'aliases' => 
      array (
      ),
      'reference' => '585824702f534f8d3cf7fab7225e8466cc4b7493',
    ),
    'league/flysystem-aws-s3-v3' => 
    array (
      'pretty_version' => '1.0.29',
      'version' => '1.0.29.0',
      'aliases' => 
      array (
      ),
      'reference' => '4e25cc0582a36a786c31115e419c6e40498f6972',
    ),
    'maatwebsite/excel' => 
    array (
      'pretty_version' => '3.1.21',
      'version' => '3.1.21.0',
      'aliases' => 
      array (
      ),
      'reference' => '405ff5f0dd014a0d5a1fdb8fd6f525a9a1ece3f6',
    ),
    'maennchen/zipstream-php' => 
    array (
      'pretty_version' => '2.1.0',
      'version' => '2.1.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c4c5803cc1f93df3d2448478ef79394a5981cc58',
    ),
    'markbaker/complex' => 
    array (
      'pretty_version' => '1.5.0',
      'version' => '1.5.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c3131244e29c08d44fefb49e0dd35021e9e39dd2',
    ),
    'markbaker/matrix' => 
    array (
      'pretty_version' => '1.2.1',
      'version' => '1.2.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '182d44c3b2e3b063468f7481ae3ef71c69dc1409',
    ),
    'mockery/mockery' => 
    array (
      'pretty_version' => '1.3.3',
      'version' => '1.3.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '60fa2f67f6e4d3634bb4a45ff3171fa52215800d',
    ),
    'monolog/monolog' => 
    array (
      'pretty_version' => '2.1.1',
      'version' => '2.1.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f9eee5cec93dfb313a38b6b288741e84e53f02d5',
    ),
    'mtdowling/jmespath.php' => 
    array (
      'pretty_version' => '2.6.0',
      'version' => '2.6.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '42dae2cbd13154083ca6d70099692fef8ca84bfb',
    ),
    'myclabs/deep-copy' => 
    array (
      'pretty_version' => '1.10.1',
      'version' => '1.10.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '969b211f9a51aa1f6c01d1d2aef56d3bd91598e5',
      'replaced' => 
      array (
        0 => '1.10.1',
      ),
    ),
    'myclabs/php-enum' => 
    array (
      'pretty_version' => '1.7.6',
      'version' => '1.7.6.0',
      'aliases' => 
      array (
      ),
      'reference' => '5f36467c7a87e20fbdc51e524fd8f9d1de80187c',
    ),
    'nesbot/carbon' => 
    array (
      'pretty_version' => '2.39.0',
      'version' => '2.39.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '0a41ea7f7fedacf307b7a339800e10356a042918',
    ),
    'nikic/php-parser' => 
    array (
      'pretty_version' => 'v4.9.1',
      'version' => '4.9.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '88e519766fc58bd46b8265561fb79b54e2e00b28',
    ),
    'okipa/laravel-bootstrap-components' => 
    array (
      'pretty_version' => '1.0.10',
      'version' => '1.0.10.0',
      'aliases' => 
      array (
      ),
      'reference' => 'da028de20bff0addd396031efe6342daf4155b72',
    ),
    'okipa/laravel-html-helper' => 
    array (
      'pretty_version' => '1.3.1',
      'version' => '1.3.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'fb9ac83ac908e8348dfa1784200b98a0a559c06a',
    ),
    'opis/closure' => 
    array (
      'pretty_version' => '3.5.6',
      'version' => '3.5.6.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e8d34df855b0a0549a300cb8cb4db472556e8aa9',
    ),
    'orchestra/parser' => 
    array (
      'pretty_version' => 'v4.0.0',
      'version' => '4.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '4ec5a2c362a55b75f4f28207b73b5d24991bbbfc',
    ),
    'paragonie/random_compat' => 
    array (
      'pretty_version' => 'v9.99.99',
      'version' => '9.99.99.0',
      'aliases' => 
      array (
      ),
      'reference' => '84b4dfb120c6f9b4ff7b3685f9b8f1aa365a0c95',
    ),
    'phar-io/manifest' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '2df402786ab5368a0169091f61a7c1e0eb6852d0',
    ),
    'phar-io/version' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a70c0ced4be299a63d32fa96d9281d03e94041df',
    ),
    'phpdocumentor/reflection-common' => 
    array (
      'pretty_version' => '2.2.0',
      'version' => '2.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '1d01c49d4ed62f25aa84a747ad35d5a16924662b',
    ),
    'phpdocumentor/reflection-docblock' => 
    array (
      'pretty_version' => '5.2.1',
      'version' => '5.2.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd870572532cd70bc3fab58f2e23ad423c8404c44',
    ),
    'phpdocumentor/type-resolver' => 
    array (
      'pretty_version' => '1.3.0',
      'version' => '1.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e878a14a65245fbe78f8080eba03b47c3b705651',
    ),
    'phpoffice/phpspreadsheet' => 
    array (
      'pretty_version' => '1.14.1',
      'version' => '1.14.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '2383aad5689778470491581442aab38cec41bf1d',
    ),
    'phpoption/phpoption' => 
    array (
      'pretty_version' => '1.7.5',
      'version' => '1.7.5.0',
      'aliases' => 
      array (
      ),
      'reference' => '994ecccd8f3283ecf5ac33254543eb0ac946d525',
    ),
    'phpspec/prophecy' => 
    array (
      'pretty_version' => 'v1.10.3',
      'version' => '1.10.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '451c3cd1418cf640de218914901e51b064abb093',
    ),
    'phpunit/php-code-coverage' => 
    array (
      'pretty_version' => '5.3.2',
      'version' => '5.3.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c89677919c5dd6d3b3852f230a663118762218ac',
    ),
    'phpunit/php-file-iterator' => 
    array (
      'pretty_version' => '1.4.5',
      'version' => '1.4.5.0',
      'aliases' => 
      array (
      ),
      'reference' => '730b01bc3e867237eaac355e06a36b85dd93a8b4',
    ),
    'phpunit/php-text-template' => 
    array (
      'pretty_version' => '1.2.1',
      'version' => '1.2.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '31f8b717e51d9a2afca6c9f046f5d69fc27c8686',
    ),
    'phpunit/php-timer' => 
    array (
      'pretty_version' => '1.0.9',
      'version' => '1.0.9.0',
      'aliases' => 
      array (
      ),
      'reference' => '3dcf38ca72b158baf0bc245e9184d3fdffa9c46f',
    ),
    'phpunit/php-token-stream' => 
    array (
      'pretty_version' => '2.0.2',
      'version' => '2.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '791198a2c6254db10131eecfe8c06670700904db',
    ),
    'phpunit/phpunit' => 
    array (
      'pretty_version' => '6.5.14',
      'version' => '6.5.14.0',
      'aliases' => 
      array (
      ),
      'reference' => 'bac23fe7ff13dbdb461481f706f0e9fe746334b7',
    ),
    'phpunit/phpunit-mock-objects' => 
    array (
      'pretty_version' => '5.0.10',
      'version' => '5.0.10.0',
      'aliases' => 
      array (
      ),
      'reference' => 'cd1cf05c553ecfec36b170070573e540b67d3f1f',
    ),
    'prettus/l5-repository' => 
    array (
      'pretty_version' => '2.6.46',
      'version' => '2.6.46.0',
      'aliases' => 
      array (
      ),
      'reference' => '5d5379a838d349447f1e09dcdc0426dfde3affb1',
    ),
    'prettus/laravel-validation' => 
    array (
      'pretty_version' => '1.2.2',
      'version' => '1.2.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '3d43037c2f497df3f8fbf3d8c16954a83c72e530',
    ),
    'psr/container' => 
    array (
      'pretty_version' => '1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b7ce3b176482dbbc1245ebf52b181af44c2cf55f',
    ),
    'psr/event-dispatcher-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/http-client' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '2dfb5f6c5eff0e91e20e913f8c5452ed95b86621',
    ),
    'psr/http-client-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/http-factory' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '12ac7fcd07e5b077433f5f2bee95b3a771bf61be',
    ),
    'psr/http-message' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f6561bf28d520154e4b0ec72be95418abe6d9363',
    ),
    'psr/http-message-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/log' => 
    array (
      'pretty_version' => '1.1.3',
      'version' => '1.1.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '0f73288fd15629204f9d42b7055f72dacbe811fc',
    ),
    'psr/log-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0.0',
        1 => '1.0',
      ),
    ),
    'psr/simple-cache' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
    ),
    'psy/psysh' => 
    array (
      'pretty_version' => 'v0.9.12',
      'version' => '0.9.12.0',
      'aliases' => 
      array (
      ),
      'reference' => '90da7f37568aee36b116a030c5f99c915267edd4',
    ),
    'ralouphie/getallheaders' => 
    array (
      'pretty_version' => '3.0.3',
      'version' => '3.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '120b605dfeb996808c31b6477290a714d356e822',
    ),
    'ramsey/uuid' => 
    array (
      'pretty_version' => '3.9.3',
      'version' => '3.9.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '7e1633a6964b48589b142d60542f9ed31bd37a92',
    ),
    'rhumsaa/uuid' => 
    array (
      'replaced' => 
      array (
        0 => '3.9.3',
      ),
    ),
    'sebastian/code-unit-reverse-lookup' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '4419fcdb5eabb9caa61a27c7a1db532a6b55dd18',
    ),
    'sebastian/comparator' => 
    array (
      'pretty_version' => '2.1.3',
      'version' => '2.1.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '34369daee48eafb2651bea869b4b15d75ccc35f9',
    ),
    'sebastian/diff' => 
    array (
      'pretty_version' => '2.0.1',
      'version' => '2.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '347c1d8b49c5c3ee30c7040ea6fc446790e6bddd',
    ),
    'sebastian/environment' => 
    array (
      'pretty_version' => '3.1.0',
      'version' => '3.1.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'cd0871b3975fb7fc44d11314fd1ee20925fce4f5',
    ),
    'sebastian/exporter' => 
    array (
      'pretty_version' => '3.1.2',
      'version' => '3.1.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '68609e1261d215ea5b21b7987539cbfbe156ec3e',
    ),
    'sebastian/global-state' => 
    array (
      'pretty_version' => '2.0.0',
      'version' => '2.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e8ba02eed7bbbb9e59e43dedd3dddeff4a56b0c4',
    ),
    'sebastian/object-enumerator' => 
    array (
      'pretty_version' => '3.0.3',
      'version' => '3.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '7cfd9e65d11ffb5af41198476395774d4c8a84c5',
    ),
    'sebastian/object-reflector' => 
    array (
      'pretty_version' => '1.1.1',
      'version' => '1.1.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '773f97c67f28de00d397be301821b06708fca0be',
    ),
    'sebastian/recursion-context' => 
    array (
      'pretty_version' => '3.0.0',
      'version' => '3.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '5b0cd723502bac3b006cbf3dbf7a1e3fcefe4fa8',
    ),
    'sebastian/resource-operations' => 
    array (
      'pretty_version' => '1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ce990bb21759f94aeafd30209e8cfcdfa8bc3f52',
    ),
    'sebastian/version' => 
    array (
      'pretty_version' => '2.0.1',
      'version' => '2.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '99732be0ddb3361e16ad77b68ba41efc8e979019',
    ),
    'swiftmailer/swiftmailer' => 
    array (
      'pretty_version' => 'v6.2.3',
      'version' => '6.2.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '149cfdf118b169f7840bbe3ef0d4bc795d1780c9',
    ),
    'symfony/console' => 
    array (
      'pretty_version' => 'v4.4.13',
      'version' => '4.4.13.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b39fd99b9297b67fb7633b7d8083957a97e1e727',
    ),
    'symfony/css-selector' => 
    array (
      'pretty_version' => 'v3.1.10',
      'version' => '3.1.10.0',
      'aliases' => 
      array (
      ),
      'reference' => '722a87478a72d95dc2a3bcf41dc9c2d13fd4cb2d',
    ),
    'symfony/debug' => 
    array (
      'pretty_version' => 'v4.4.13',
      'version' => '4.4.13.0',
      'aliases' => 
      array (
      ),
      'reference' => 'aeb73aca16a8f1fe958230fe44e6cf4c84cbb85e',
    ),
    'symfony/dom-crawler' => 
    array (
      'pretty_version' => 'v3.1.10',
      'version' => '3.1.10.0',
      'aliases' => 
      array (
      ),
      'reference' => '7eede2a901a19928494194f7d1815a77b9a473a0',
    ),
    'symfony/error-handler' => 
    array (
      'pretty_version' => 'v4.4.13',
      'version' => '4.4.13.0',
      'aliases' => 
      array (
      ),
      'reference' => '2434fb32851f252e4f27691eee0b77c16198db62',
    ),
    'symfony/event-dispatcher' => 
    array (
      'pretty_version' => 'v4.4.13',
      'version' => '4.4.13.0',
      'aliases' => 
      array (
      ),
      'reference' => '3e8ea5ccddd00556b86d69d42f99f1061a704030',
    ),
    'symfony/event-dispatcher-contracts' => 
    array (
      'pretty_version' => 'v1.1.9',
      'version' => '1.1.9.0',
      'aliases' => 
      array (
      ),
      'reference' => '84e23fdcd2517bf37aecbd16967e83f0caee25a7',
    ),
    'symfony/event-dispatcher-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.1',
      ),
    ),
    'symfony/finder' => 
    array (
      'pretty_version' => 'v4.4.13',
      'version' => '4.4.13.0',
      'aliases' => 
      array (
      ),
      'reference' => '2a78590b2c7e3de5c429628457c47541c58db9c7',
    ),
    'symfony/http-foundation' => 
    array (
      'pretty_version' => 'v4.4.13',
      'version' => '4.4.13.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e3e5a62a6631a461954d471e7206e3750dbe8ee1',
    ),
    'symfony/http-kernel' => 
    array (
      'pretty_version' => 'v4.4.13',
      'version' => '4.4.13.0',
      'aliases' => 
      array (
      ),
      'reference' => '2bb7b90ecdc79813c0bf237b7ff20e79062b5188',
    ),
    'symfony/mime' => 
    array (
      'pretty_version' => 'v4.4.13',
      'version' => '4.4.13.0',
      'aliases' => 
      array (
      ),
      'reference' => '50ad671306d3d3ffb888d95b4fb1859496831e3a',
    ),
    'symfony/polyfill-ctype' => 
    array (
      'pretty_version' => 'v1.18.1',
      'version' => '1.18.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '1c302646f6efc070cd46856e600e5e0684d6b454',
    ),
    'symfony/polyfill-iconv' => 
    array (
      'pretty_version' => 'v1.18.1',
      'version' => '1.18.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '6c2f78eb8f5ab8eaea98f6d414a5915f2e0fce36',
    ),
    'symfony/polyfill-intl-idn' => 
    array (
      'pretty_version' => 'v1.18.1',
      'version' => '1.18.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '5dcab1bc7146cf8c1beaa4502a3d9be344334251',
    ),
    'symfony/polyfill-intl-normalizer' => 
    array (
      'pretty_version' => 'v1.18.1',
      'version' => '1.18.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '37078a8dd4a2a1e9ab0231af7c6cb671b2ed5a7e',
    ),
    'symfony/polyfill-mbstring' => 
    array (
      'pretty_version' => 'v1.18.1',
      'version' => '1.18.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a6977d63bf9a0ad4c65cd352709e230876f9904a',
    ),
    'symfony/polyfill-php70' => 
    array (
      'pretty_version' => 'v1.18.1',
      'version' => '1.18.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '0dd93f2c578bdc9c72697eaa5f1dd25644e618d3',
    ),
    'symfony/polyfill-php72' => 
    array (
      'pretty_version' => 'v1.18.1',
      'version' => '1.18.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '639447d008615574653fb3bc60d1986d7172eaae',
    ),
    'symfony/polyfill-php73' => 
    array (
      'pretty_version' => 'v1.18.1',
      'version' => '1.18.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'fffa1a52a023e782cdcc221d781fe1ec8f87fcca',
    ),
    'symfony/polyfill-php80' => 
    array (
      'pretty_version' => 'v1.18.1',
      'version' => '1.18.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd87d5766cbf48d72388a9f6b85f280c8ad51f981',
    ),
    'symfony/process' => 
    array (
      'pretty_version' => 'v4.4.13',
      'version' => '4.4.13.0',
      'aliases' => 
      array (
      ),
      'reference' => '65e70bab62f3da7089a8d4591fb23fbacacb3479',
    ),
    'symfony/routing' => 
    array (
      'pretty_version' => 'v4.4.13',
      'version' => '4.4.13.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e3387963565da9bae51d1d3ab8041646cc93bd04',
    ),
    'symfony/service-contracts' => 
    array (
      'pretty_version' => 'v1.1.9',
      'version' => '1.1.9.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b776d18b303a39f56c63747bcb977ad4b27aca26',
    ),
    'symfony/thanks' => 
    array (
      'pretty_version' => 'v1.2.9',
      'version' => '1.2.9.0',
      'aliases' => 
      array (
      ),
      'reference' => '733cc7b8c09a06c9251bd35d772b453b47d98442',
    ),
    'symfony/translation' => 
    array (
      'pretty_version' => 'v4.4.13',
      'version' => '4.4.13.0',
      'aliases' => 
      array (
      ),
      'reference' => '700e6e50174b0cdcf0fa232773bec5c314680575',
    ),
    'symfony/translation-contracts' => 
    array (
      'pretty_version' => 'v1.1.9',
      'version' => '1.1.9.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a5db6f7707fd35d137b1398734f2d745c8616ea2',
    ),
    'symfony/translation-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'symfony/var-dumper' => 
    array (
      'pretty_version' => 'v4.4.13',
      'version' => '4.4.13.0',
      'aliases' => 
      array (
      ),
      'reference' => '1bef32329f3166486ab7cb88599cae4875632b99',
    ),
    'theseer/tokenizer' => 
    array (
      'pretty_version' => '1.2.0',
      'version' => '1.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '75a63c33a8577608444246075ea0af0d052e452a',
    ),
    'tightenco/collect' => 
    array (
      'pretty_version' => 'v7.25.0',
      'version' => '7.25.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '54de14fe2e8fdd0831d69601bf9c7f5e2667aa85',
    ),
    'tijsverkoyen/css-to-inline-styles' => 
    array (
      'pretty_version' => '2.2.3',
      'version' => '2.2.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b43b05cf43c1b6d849478965062b6ef73e223bb5',
    ),
    'vlucas/phpdotenv' => 
    array (
      'pretty_version' => 'v3.6.7',
      'version' => '3.6.7.0',
      'aliases' => 
      array (
      ),
      'reference' => '2065beda6cbe75e2603686907b2e45f6f3a5ad82',
    ),
    'webmozart/assert' => 
    array (
      'pretty_version' => '1.9.1',
      'version' => '1.9.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'bafc69caeb4d49c39fd0779086c03a3738cbb389',
    ),
    'yajra/laravel-datatables-buttons' => 
    array (
      'pretty_version' => 'v4.9.3',
      'version' => '4.9.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '0ba6c5e095ed1e51d09643639290cbaaa35730b8',
    ),
    'yajra/laravel-datatables-html' => 
    array (
      'pretty_version' => 'v4.30.0',
      'version' => '4.30.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ceb5eea82fed6c874478d69e35175964a72384fe',
    ),
    'yajra/laravel-datatables-oracle' => 
    array (
      'pretty_version' => 'v9.10.2',
      'version' => '9.10.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '7ccbc890aa03d645bd509c03299234dc631240ee',
    ),
  ),
);
private static $canGetVendors;
private static $installedByVendor = array();







public static function getInstalledPackages()
{
$packages = array();
foreach (self::getInstalled() as $installed) {
$packages[] = array_keys($installed['versions']);
}


if (1 === \count($packages)) {
return $packages[0];
}

return array_keys(array_flip(\call_user_func_array('array_merge', $packages)));
}









public static function isInstalled($packageName)
{
foreach (self::getInstalled() as $installed) {
if (isset($installed['versions'][$packageName])) {
return true;
}
}

return false;
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

$ranges = array();
if (isset($installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = $installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['version'])) {
return null;
}

return $installed['versions'][$packageName]['version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getPrettyVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return $installed['versions'][$packageName]['pretty_version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getReference($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['reference'])) {
return null;
}

return $installed['versions'][$packageName]['reference'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getRootPackage()
{
$installed = self::getInstalled();

return $installed[0]['root'];
}







public static function getRawData()
{
return self::$installed;
}



















public static function reload($data)
{
self::$installed = $data;
self::$installedByVendor = array();
}




private static function getInstalled()
{
if (null === self::$canGetVendors) {
self::$canGetVendors = method_exists('Composer\Autoload\ClassLoader', 'getRegisteredLoaders');
}

$installed = array();

if (self::$canGetVendors) {
foreach (ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
if (isset(self::$installedByVendor[$vendorDir])) {
$installed[] = self::$installedByVendor[$vendorDir];
} elseif (is_file($vendorDir.'/composer/installed.php')) {
$installed[] = self::$installedByVendor[$vendorDir] = require $vendorDir.'/composer/installed.php';
}
}
}

$installed[] = self::$installed;

return $installed;
}
}
