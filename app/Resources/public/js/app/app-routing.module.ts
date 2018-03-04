import {NgModule} from '@angular/core';
import {PreloadAllModules, RouterModule, Routes} from '@angular/router';
import {AuthComponent} from './core/component/auth.component';
import {AuthenticationGuard} from './core/service/auth-guard.service';

const routes: Routes = [
    {
        path: 'login',
        component: AuthComponent,
    },
    {
        path: 'dashboard',
        loadChildren: './dashboard/dashboard.module#DashboardModule',
        canLoad: [AuthenticationGuard],
    },
    {
        path: 'recipes',
        loadChildren: './recipe/recipe.module#RecipeModule',
    },
];

@NgModule({
    imports: [
        RouterModule.forRoot(routes, {
            preloadingStrategy: PreloadAllModules,
        }),
    ],
    exports: [RouterModule],
})
export class AppRoutingModule {
}
