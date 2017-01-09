import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {InquiryComponent} from './dashboard/component/inquiry.component';

const appRoutes: Routes = [
];

@NgModule({
    imports: [
        RouterModule.forRoot(appRoutes),
    ],
    exports: [RouterModule]
})
export class AppRoutingModule {}
