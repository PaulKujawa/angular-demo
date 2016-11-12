import {CommonModule} from "@angular/common";
import {NgModule} from '@angular/core';
import {FlashMessageComponent} from "./component/flash-message.component";
import {RoutingService} from "./service/routing.service";
import {FlashMessageService} from "./service/flash-message.service";
import {TranslationService} from "./service/translation.service";
import {NavBarComponent} from "./component/nav-bar.component";
import {RouterModule} from "@angular/router";
import {SharedModule} from "../shared/shared.module";

@NgModule({
    imports: [
        CommonModule,
        SharedModule,
        RouterModule,
    ],
    declarations: [
        FlashMessageComponent,
        NavBarComponent,
    ],
    exports: [
        FlashMessageComponent,
        NavBarComponent,
    ],
    providers: [
        FlashMessageService,
        RoutingService,
        TranslationService,
    ]
})
export class CoreModule {}