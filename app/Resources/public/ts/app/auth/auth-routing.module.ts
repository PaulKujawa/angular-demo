import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {AuthComponent} from './component/auth.component';
import {AuthFormComponent} from './component/auth-form.component';

const authRoutes: Routes = [
    {
        path: 'login',
        component: AuthComponent,
        children: [
            {
                path: '',
                component: AuthFormComponent
            },
        ]
    },
];

@NgModule({
    imports: [
        RouterModule.forChild(authRoutes),
    ],
    exports: [RouterModule]
})
export class AuthRoutingModule {}
