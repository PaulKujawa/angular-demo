import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {RouterModule} from '@angular/router';
import {FormsModule} from '@angular/forms';
import {SharedModule} from '../shared/shared.module';
import {FlashMessageComponent} from './component/flash-message.component';
import {RoutingService} from './service/routing.service';
import {FlashMessageService} from './service/flash-message.service';
import {TranslationService} from './service/translation.service';
import {NavBarComponent} from './component/nav-bar.component';
import {AuthGuard} from './service/auth-guard.service';
import {AuthService} from './service/auth.service';
import {AuthComponent} from './component/auth.component';
import {AuthRepository} from './repository/auth.repository';

@NgModule({
    imports: [
        CommonModule,
        FormsModule,
        SharedModule,
        RouterModule,
    ],
    declarations: [
        AuthComponent,
        FlashMessageComponent,
        NavBarComponent,
    ],
    exports: [
        FlashMessageComponent,
        NavBarComponent,
    ],
    providers: [
        AuthGuard,
        AuthService,
        AuthRepository,
        FlashMessageService,
        RoutingService,
        TranslationService,
    ]
})
export class CoreModule {}
