import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {InquiryComponent} from './inquiry/component/inquiry.component';

const appRoutes: Routes = [
    {path: '', component: InquiryComponent, pathMatch: 'full'},
];

@NgModule({
    imports: [
        RouterModule.forRoot(appRoutes),
    ],
    exports: [RouterModule]
})
export class AppRoutingModule {}
