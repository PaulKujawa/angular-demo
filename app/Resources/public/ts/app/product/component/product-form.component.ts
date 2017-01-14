import {Component, Input} from '@angular/core';
import {FlashMessageService} from '../../core/service/flash-message.service';
import {FlashMessage} from '../../core/model/flash-message';
import {ProductRepository} from '../repository/product.repository';
import {Product} from '../model/product';
import {Router} from '@angular/router';

@Component({
    selector: 'product-form',
    template: `
        <form #productForm="ngForm" (ngSubmit)="onSubmit()" *ngIf="product">        
            <div class="row">
                <div class="col-xs-12 col-sm-6 form-group">
                    <label>{{'app.product.form.name'|trans}}</label>
                    <input type="text" required class="form-control" name="name" [(ngModel)]="product.name">
                </div>
                <div class="col-xs-12 col-sm-6 form-group">
                    <label>{{'app.product.form.manufacturer'|trans}}</label>
                    <input type="text" class="form-control" name="manufacturer" [(ngModel)]="product.manufacturer">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 form-group">
                    <label>{{'app.product.form.gr'|trans}}</label>
                    <input type="number" required class="form-control" name="gr" [(ngModel)]="product.gr">
                </div> 
                <div class="col-xs-12 col-sm-4 form-group">
                    <label>{{'app.product.form.carbs'|trans}}</label>
                    <input type="number" required step="0.1" class="form-control" name="carbs" [(ngModel)]="product.carbs">
                </div>
                <div class="col-xs-12 col-sm-4 form-group">
                    <label>{{'app.product.form.fat'|trans}}</label>
                    <input type="number" required step="0.1" class="form-control" name="fat" [(ngModel)]="product.fat">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 form-group">
                    <label>{{'app.product.form.protein'|trans}}</label>
                    <input type="number" required step="0.1" class="form-control" name="protein" [(ngModel)]="product.protein">
                </div>
                <div class="col-xs-12 col-sm-4 form-group">
                    <label>{{'app.product.form.sugar'|trans}}</label>
                    <input type="number" required step="0.1" class="form-control" name="sugar" [(ngModel)]="product.sugar">
                </div>
                <div class="col-xs-12 col-sm-4 form-group">
                    <label>{{'app.product.form.gfat'|trans}}</label>
                    <input type="number" required step="0.1" class="form-control" name="gfat" [(ngModel)]="product.gfat">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 checkbox">
                    <label>
                        <input type="checkbox" name="vegan" [(ngModel)]="product.vegan">
                        {{'app.product.form.vegan'|trans}}
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="button" class="btn btn-danger">
                        {{'app.common.delete'|trans}}
                    </button>
                    <button type="submit" class="btn btn-primary" [disabled]="!productForm.form.valid">
                        {{'app.common.submit'|trans}}
                    </button>
                </div>
            </div>
        </form>
    `
})
export class ProductFormComponent {
    @Input() product: Product;

    constructor(private router: Router,
                private productRepository: ProductRepository,
                private flashMsgService: FlashMessageService) {}

    onSubmit(): void {
        // todo dqw

        this.router.navigate(['products']);
    }
}
