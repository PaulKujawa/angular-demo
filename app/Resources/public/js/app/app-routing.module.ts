import {NgModule} from '@angular/core';
import {PreloadAllModules, RouterModule, Routes} from '@angular/router';
import {AuthComponent} from './core/component/auth.component';
import {AuthenticationGuard} from './core/service/auth-guard.service';

const appRoutes: Routes = [
    {
        path: 'login',
        component: AuthComponent,
    },
    {
        path: 'products',
        loadChildren: './product/product.module#ProductModule',
        canLoad: [AuthenticationGuard]
    },
    {
        path: 'recipes',
        loadChildren: './recipe/recipe.module#RecipeModule',
    },
];

@NgModule({
    imports: [
        RouterModule.forRoot(appRoutes, {
            preloadingStrategy: PreloadAllModules,
        }),
    ],
    exports: [RouterModule],
})
export class AppRoutingModule {
}
