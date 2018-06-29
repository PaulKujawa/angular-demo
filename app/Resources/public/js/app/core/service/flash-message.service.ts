import {Injectable} from '@angular/core';
import {MatSnackBar} from '@angular/material/snack-bar';
import {CoreModule} from 'app/core/core.module';
import {TranslationService} from 'app/core/service/translation.service';

interface TranslateMethod {
    id: string;
    parameters?: object;
    domain?: string;
}

@Injectable({
    providedIn: CoreModule,
})
export class FlashMessageService {
    public constructor(private translationService: TranslationService,
                       private matSnackBar: MatSnackBar) {
    }

    public showSuccess(message: TranslateMethod, duration = 3000): void {
        const msg = this.translate(message);

        this.matSnackBar.open(msg, 'Okay', {duration});
    }

    public showFailure(message: TranslateMethod): void {
        const msg = this.translate(message);

        this.matSnackBar.open(msg, 'Dismiss');
    }

    private translate(message: TranslateMethod): string {
        return this.translationService.trans(message.id, message.parameters, message.domain);
    }
}
