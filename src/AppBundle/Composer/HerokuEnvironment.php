<?php
/**
 * Created by IntelliJ IDEA.
 * User: henri
 * Date: 06/06/15
 * Time: 10:28
 */

namespace AppBundle\Composer;

use Composer\Script\Event;

class HerokuEnvironment
{
    /**
     * Populate Heroku environment
     *
     * @param Event $event Event
     */
    public static function populateEnvironment(Event $event)
    {
        $url = getenv('DATABASE_URL');

        if ($url) {
            $url = parse_url($url);
            putenv("SYMFONY__DATABASE_HOST={$url['host']}");
            putenv("SYMFONY__DATABASE_USER={$url['user']}");
            putenv("SYMFONY__DATABASE_PASSWORD={$url['pass']}");

            $db = substr($url['path'], 1);
            putenv("SYMFONY__DATABASE_NAME={$db}");
        }

        $io = $event->getIO();
        $io->write('DATABASE_URL=' . getenv('DATABASE_URL'));
    }
}