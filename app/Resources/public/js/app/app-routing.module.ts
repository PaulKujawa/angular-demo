import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {AuthComponent} from './core/component/auth.component';

const appRoutes: Routes = [
    {
        path: 'login',
        component: AuthComponent,
    },
];

@NgModule({
    imports: [
        RouterModule.forRoot(appRoutes),
    ],
    exports: [RouterModule],
})
export class AppRoutingModule {}
