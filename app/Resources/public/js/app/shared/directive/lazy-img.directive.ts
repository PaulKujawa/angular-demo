import {AfterViewInit, Directive, ElementRef, HostBinding, Input} from '@angular/core';

@Directive({
    selector: '[appLazyImg]',
})
export class LazyImgDirective implements AfterViewInit {
    private static sharedIntersectionObserver = new IntersectionObserver((entries) => {
        entries
            .filter((entry) => entry.isIntersecting)
            .map((entry) => entry.target)
            .forEach((target) => {
                target.setAttribute('src', target.getAttribute('data-src')!);
                LazyImgDirective.sharedIntersectionObserver.unobserve(target);
            });
    }, {
        rootMargin: '0px 0px 256px 0px',
    });

    @Input() @HostBinding('attr.data-src') public lazyImgSrc: string;

    constructor(private elementRef: ElementRef) {
        this.elementRef = elementRef;
    }

    public ngAfterViewInit(): void {
        // TODO if browser doesn't support scrolling (crawler) load directly
        LazyImgDirective.sharedIntersectionObserver.observe(this.elementRef.nativeElement);
    }
}
