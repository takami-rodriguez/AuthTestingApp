<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{

    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        ->orWhere('email', 'LIKE', "%{$value}%");
                });
            });
        });
        $users = QueryBuilder::for(User::where('admin','!=',1))
            ->defaultSort('name')
            ->allowedSorts(['name', 'email'])
            ->allowedFilters(['name', 'email', $globalSearch])
            ->paginate(8)
            ->withQueryString();

        $manager = app('impersonate');

        return Inertia::render('Dashboard', ['users' => $users,'is_impersonating' => $manager->isImpersonating()])->table(function (InertiaTable $table) {
            $table->column('name', 'User Name', sortable: true, searchable: true);
            $table->column('email', 'Email Address', sortable: true, searchable: true);
            $table->column('created_at', 'Join Date', canBeHidden: false, sortable: true, searchable: true);
            $table->column(label: 'Actions');
        });
    }

    public function impersonate(User $user)
    {
        auth()->user()->impersonate($user);

        return redirect()->route('dashboard');
    }

    public function leaveImpersonate()
    {
        auth()->user()->leaveImpersonation();

        return redirect()->route('dashboard');
    }
}
