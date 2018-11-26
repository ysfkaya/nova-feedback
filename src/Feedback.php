<?php

namespace Ysfkaya\NovaFeedback;


use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use UniSharp\LaravelFilemanager\Lfm;
use Ysfkaya\NovaFeedback\Models\Development as DevelopmentModel;
use Ysfkaya\NovaFeedback\Models\ErrorReport;
use Ysfkaya\NovaFeedback\Models\ErrorReportReply;
use Ysfkaya\NovaFeedback\Observers\DevelopmentObserver;
use Ysfkaya\NovaFeedback\Observers\ErrorReportObserver;
use Ysfkaya\NovaFeedback\Observers\ErrorReportReplyObserver;

/**
 * Class Feedback
 * @package Ysfkaya\NovaFeedback
 */
class Feedback
{


    /**
     * @param Request $request
     * @param bool $default
     * @return bool
     */
    public static function hasOwnerRole($request, $default = true)
    {
        $hasRoleable = self::hasRoleableUser($request);

        if (!$hasRoleable) {
            return $default;
        }

        $roleName = config('nova-feedback.roles.owner_role_name');

        if (!$roleName) {
            return $default;
        }

        return $request->user()->hasRole($roleName);
    }

    /**
     * @param Request $request
     * @param bool $default
     * @return bool
     */
    public static function hasDeveloperRole($request, $default = true)
    {

        $hasRoleable = self::hasRoleableUser($request);

        if (!$hasRoleable) {
            return $default;
        }

        $roleName = config('nova-feedback.roles.developer_role_name');

        if (!$roleName) {
            return $default;
        }

        return $request->user()->hasRole($roleName);
    }

    /**
     * @param Request $request
     * @param bool $default
     * @return bool
     */
    public static function authorize($request, $default = true)
    {
        $hasRoleable = self::hasRoleableUser($request);

        if (!$hasRoleable) {
            return $default;
        }

        $roles = array_filter(Arr::flatten([
            config('nova-feedback.roles.developer_role_name'),
            config('nova-feedback.roles.owner_role_name')
        ]));

        if (count($roles) === 0) {
            return $default;
        }

        return $request->user()->hasAnyRole($roles);
    }


    /**
     * @param Request $request
     *
     * @return bool
     */
    public static function hasRoleableUser(Request $request)
    {
        $user = $request->user();

        return array_key_exists('Spatie\\Permission\\Traits\\HasPermissions', trait_uses_recursive($user)) && config('nova-feedback.roles.enable', true);

    }


    /**
     * @return void
     */
    public static function setOptions()
    {
        $config = app(Repository::class);

        $routeOptions = [
            'middleware' => $config->get('lfm.middlewares'),
            'prefix' => $config->get('lfm.url_prefix')
        ];

        Route::group($routeOptions, function () {
            Lfm::routes();
        });
    }

    /**
     * @return bool
     */
    public static function isInstalled()
    {
        return Schema::hasTable('error_reports')
            && Schema::hasTable('error_report_replies')
            && Schema::hasTable('error_report_participants')
            && Schema::hasTable('developments');
    }



    /**
     * @return void
     */
    public static function observers()
    {
        ErrorReportReply::observe(ErrorReportReplyObserver::class);

        ErrorReport::observe(ErrorReportObserver::class);

        DevelopmentModel::observe(DevelopmentObserver::class);
    }

}