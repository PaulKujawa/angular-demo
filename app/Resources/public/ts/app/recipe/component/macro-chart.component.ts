import {Component, Input, OnChanges} from '@angular/core';
import {Macros} from "../model/macros";

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
    `
})
export class MacroChartComponent implements OnChanges {
    @Input() macros: Macros;
    @Input() type: 'danger'|'info'|'warning'|'success';
    totalGr: number;

    ngOnChanges(): void {
        this.totalGr = this.macros.carbs + this.macros.protein + this.macros.fat;
    }

    getPercentage(macro: number): string {
        return (100 * macro / this.totalGr) + '%';
    }
}
