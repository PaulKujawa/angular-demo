import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {InquiryComponent} from './component/inquiry.component';
import {StartPageComponent} from './component/start-page.component';

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
