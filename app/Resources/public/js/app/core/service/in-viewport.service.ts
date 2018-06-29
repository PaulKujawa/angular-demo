import {ElementRef, Inject, Injectable} from '@angular/core';
import {CoreModule} from 'app/core/core.module';
import {WindowInjectToken} from 'app/core/core.token';

@Injectable({
    providedIn: CoreModule,
})
export class InViewportService {
    constructor(@Inject(WindowInjectToken) private window: Window) {
    }

    public isVisible(element: ElementRef, percentage: number = 100): boolean {
        const rect = element.nativeElement.getBoundingClientRect();
        percentage /= 100;
        const withinVertical = rect.top >= 0 && rect.top + rect.height * percentage <= this.window.innerHeight;

        return withinVertical && (rect.left >= 0 && rect.left + rect.width * percentage <= this.window.innerWidth);
    }
}
