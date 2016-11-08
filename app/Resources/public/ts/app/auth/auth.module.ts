import {NgModule} from '@angular/core';
import {CommonModule} from "@angular/common";
import {SharedModule} from "../shared/shared.module";
import {AuthRoutingModule} from "./auth-routing.module";
import {AuthComponent} from "./component/auth.component";
import {FormsModule} from "@angular/forms";
import {AuthRepository} from "./repository/auth.repository";
import {AuthService} from "./service/auth.service";

@NgModule({
    imports: [
        CommonModule,
        FormsModule,
        SharedModule,
        AuthRoutingModule,
    ],
    declarations: [
        AuthComponent,
    ],
    exports: [],
    providers: [
        AuthService,
        AuthRepository,
    ]
})
export class AuthModule {}
