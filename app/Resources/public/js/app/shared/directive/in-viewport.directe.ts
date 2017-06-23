import {
    Directive, ElementRef, EventEmitter, Input, NgZone, OnChanges, OnDestroy, OnInit, Output,
    SimpleChanges,
} from '@angular/core';
import {Observable, Subscription} from 'rxjs';
import {InViewportService} from '../../core/service/in-viewport.service';

interface InViewportConfig {
    percentage: number;
}

@Directive({
    selector: '[in-viewport]',
})
export class InViewportDirective implements OnInit, OnChanges, OnDestroy {
    private static sharedSource = Observable.merge(
        Observable.fromEvent(window, 'resize'),
        Observable.fromEvent(window, 'scroll'),
    )
    .auditTime(100)
    .share();

    @Input('in-viewport') public config?: InViewportConfig;
    @Input() public customEvent?: Observable<any>;
    @Output() public visible = new EventEmitter<boolean>();
    private readonly defaultConfig: InViewportConfig = {percentage: 100};
    private subscription: Subscription;

    constructor(private el: ElementRef,
                private zone: NgZone,
                private inViewportService: InViewportService) {
    }

    public ngOnInit(): void {
        const source = this.customEvent
            ? Observable.merge(InViewportDirective.sharedSource, this.customEvent)
            : InViewportDirective.sharedSource;

        this.subscription = source.subscribe((nil) => this.check());
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
        if (!this.inViewportService.isVisible(this.el, this.config!.percentage)) {
            return;
        }

        this.subscription.unsubscribe();
        this.visible.emit(true);
    }
}
