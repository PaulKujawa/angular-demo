import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {AuthComponent} from "./component/auth.component";

const authRoutes: Routes = [
    {path: 'login', component: AuthComponent},
];

@NgModule({
    imports: [
        RouterModule.forChild(authRoutes),
    ],
    exports: [RouterModule]
})
export class AuthRoutingModule {}
