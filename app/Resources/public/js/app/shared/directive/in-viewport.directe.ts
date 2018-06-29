import {
    Directive,
    ElementRef,
    EventEmitter,
    Input,
    NgZone,
    OnChanges,
    OnDestroy,
    OnInit,
    Output,
    SimpleChanges,
} from '@angular/core';
import {InViewportService} from 'app/core/service/in-viewport.service';
import {fromEvent, merge, Observable, Subscription} from 'rxjs';
import {auditTime, share} from 'rxjs/operators';

interface InViewportConfig {
    percentage: number;
}

@Directive({
    selector: '[appInViewport]',
})
export class InViewportDirective implements OnInit, OnChanges, OnDestroy {
    private static sharedSource = merge(
        fromEvent(window, 'resize', {passive: true}),
        fromEvent(window, 'scroll', {passive: true}),
    ).pipe(
        auditTime(100),
        share(),
    );

    @Input() public config?: InViewportConfig;
    @Input() public customEvent?: Observable<any>;
    @Output() public visible = new EventEmitter<boolean>();
    private readonly defaultConfig: InViewportConfig = {percentage: 100};
    private subscription: Subscription;

    constructor(private elementRef: ElementRef,
                private zone: NgZone,
                private inViewportService: InViewportService) {
    }

    public ngOnInit(): void {
        const source = this.customEvent
            ? merge(InViewportDirective.sharedSource, this.customEvent)
            : InViewportDirective.sharedSource;

        this.subscription = source.subscribe(() => this.check());
        this.zone.runOutsideAngular(() => {
            setTimeout(() => this.check(), 1);
        });
    }

    public ngOnChanges(changes: SimpleChanges): void {
        if (changes.config) {
            this.config = typeof changes.config.currentValue === 'string'
                ? this.defaultConfig
                : changes.config.currentValue;
        }
    }

    public ngOnDestroy(): void {
        this.subscription.unsubscribe();
    }

    private check(): void {
        if (!this.inViewportService.isVisible(this.elementRef, this.config!.percentage)) {
            return;
        }

        this.subscription.unsubscribe();
        this.visible.emit(true);
    }
}
