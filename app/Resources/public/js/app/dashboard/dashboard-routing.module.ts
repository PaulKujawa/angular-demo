import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {AuthenticationGuard} from 'app/core/service/auth-guard.service';
import {DashboardComponent} from 'app/dashboard/component/dashboard.component';
import {PlaceholderComponent} from 'app/dashboard/component/placeholder.component';

const routes: Routes = [
    {
        path: '',
        component: DashboardComponent,
        canActivate: [AuthenticationGuard],
        children: [
            {
                path: '',
                component: PlaceholderComponent,
                canActivateChild: [AuthenticationGuard],
            },
        ],
    },
];

@NgModule({
    imports: [
        RouterModule.forChild(routes),
    ],
    exports: [RouterModule],
})
export class DashboardRoutingModule {
}
