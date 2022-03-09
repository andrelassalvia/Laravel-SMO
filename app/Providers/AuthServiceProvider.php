<?php

namespace App\Providers;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Funcao;
use App\Models\Exame;
use App\Models\Setor;
use App\Models\Grupo;
use App\Models\Risco;
use App\Models\TipoAtendimento;
use App\Models\Permissao;
use App\Models\TipoUsuario;
use App\Models\User;
use App\Policies\Admin\FuncaoPolicy;
use App\Policies\Admin\ExamePolicy;
use App\Policies\Admin\SetorPolicy;
use App\Policies\Admin\GrupoPolicy;
use App\Policies\Admin\RiscoPolicy;
use App\Policies\Admin\TipoAtendimentoPolicy;
use App\Policies\Admin\PermissaoPolicy;
use App\Policies\Admin\TipoUsuarioPolicy;
use App\Policies\Admin\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Funcao::class => FuncaoPolicy::class,
        Exame::class => ExamePolicy::class,
        Setor::class => SetorPolicy::class,
        Grupo::class => GrupoPolicy::class,
        Risco::class => RiscoPolicy::class,
        TipoAtendimento::class => TipoAtendimentoPolicy::class,
        Permissao::class => PermissaoPolicy::class,
        TipoUsuario::class => TipoUsuarioPolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('update-post', function (User $user, Post $post) {
        //     return $user->id === $post->user_id;
        // });

        //
    }
}
