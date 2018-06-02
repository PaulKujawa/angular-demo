import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {InquiryComponent} from 'app/start-page/component/inquiry.component';
import {StartPageComponent} from 'app/start-page/component/start-page.component';

const routes: Routes = [
    {
        path: '',
        component: StartPageComponent,
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
        RouterModule.forChild(routes),
    ],
    exports: [RouterModule],
})
export class StartPageRoutingModule {
}
