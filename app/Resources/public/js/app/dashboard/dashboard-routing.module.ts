import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {DashboardComponent} from './component/dashboard.component';
import {InquiryComponent} from './component/inquiry.component';

const recipeRoutes: Routes = [
    {
        path: '',
        component: DashboardComponent,
        pathMatch: 'full',
        children: [
            {
                path: '',
                component: InquiryComponent,
            },
        ],
    },
];

@NgModule({
    imports: [
        RouterModule.forChild(recipeRoutes),
    ],
    exports: [RouterModule],
})
export class DashboardRoutingModule {
}
