import {Component, Input, OnChanges} from '@angular/core';
import {Macros} from '../model/macros';

@Component({
    selector: 'macro-chart',
    template: `
        <div class="progress">
            <div class="progress-bar progress-bar-warning" role="progressbar" [style.width]="getPercentage(macros.carbs)">
                {{macros.carbs}} gr
            </div>
        </div>
        <div class="progress">
            <div class="progress-bar progress-bar-info" role="progressbar" [style.width]="getPercentage(macros.protein)">
                {{macros.protein}} gr
            </div>
        </div>
        <div class="progress">
            <div class="progress-bar progress-bar-danger" role="progressbar" [style.width]="getPercentage(macros.fat)">
                {{macros.fat}} gr
            </div>
        </div>
    `,
})
export class MacroChartComponent implements OnChanges {
    @Input() public macros: Macros;
    @Input() public type: 'danger'|'info'|'warning'|'success';
    public totalGr: number;

    public ngOnChanges(): void {
        this.totalGr = this.macros.carbs + this.macros.protein + this.macros.fat;
    }

    public getPercentage(macro: number): string {
        return (100 * macro / this.totalGr) + '%';
    }
}
