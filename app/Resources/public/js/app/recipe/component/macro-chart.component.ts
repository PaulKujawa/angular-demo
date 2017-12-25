import {Component, Input, OnChanges} from '@angular/core';
import {Macros} from '../model/macros';

@Component({
    selector: 'macro-chart',
    template: `
        <div class="app-macro-chart">
            <div style="background-color: #ffd54f"
                 [style.width.%]="getProportion(macros.carbs)">
                {{ getProportion(macros.carbs) | number:'1.0-0' }}
            </div>
            <div style="background-color: #7986cb"
                 [style.width.%]="getProportion(macros.protein)">
                {{ getProportion(macros.protein) | number:'1.0-0' }}
            </div>
            <div style="background-color: #e57373"
                 [style.width.%]="getProportion(macros.fat)">
                {{ getProportion(macros.fat) | number:'1.0-0' }}
            </div>
        </div>
    `,
})
export class MacroChartComponent implements OnChanges {
    @Input() public macros: Macros;
    public totalGr: number;

    public ngOnChanges(): void {
        this.totalGr = this.macros.carbs + this.macros.protein + this.macros.fat;
    }

    public getProportion(macro: number): number {
        return (100 * macro / this.totalGr);
    }
}
