import {Component, Input, OnInit} from '@angular/core';
import {FormBuilder, FormGroup} from '@angular/forms';
import {Router} from '@angular/router';
import {Observable} from 'rxjs/Observable';
import {ProductRequestDto} from '../model/dto/product-request.dto';
import {Product} from '../model/product';
import {ProductState} from '../service/product.state';

@Component({
    selector: 'product-form',
    template: `
        <form [formGroup]="productForm" (ngSubmit)="onSubmit()" novalidate>
            <div class="row">
                <div class="col-xs-12 col-sm-5 form-group">
                    <label>{{'app.product.form.name' | trans}}</label>
                    <input class="form-control"
                           formControlName="name">
                </div>
                <div class="col-xs-12 col-sm-4 form-group">
                    <label>{{'app.product.form.manufacturer' | trans}}</label>
                    <input class="form-control"
                           formControlName="manufacturer">
                </div>
                <div class="col-xs-12 col-sm-3 form-group">
                    <label>{{'app.product.form.gr' | trans}}</label>
                    <input type="number"
                           class="form-control"
                           formControlName="gr">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 form-group">
                    <label>{{'app.product.form.kcal' | trans}}</label>
                    <input type="number"
                           class="form-control"
                           formControlName="kcal">
                </div>
                <div class="col-xs-12 col-sm-4 form-group">
                    <label>{{'app.product.form.carbs' | trans}}</label>
                    <input type="number"
                           step="0.1"
                           class="form-control"
                           formControlName="carbs">
                </div>
                <div class="col-xs-12 col-sm-4 form-group">
                    <label>{{'app.product.form.fat' | trans}}</label>
                    <input type="number"
                           step="0.1"
                           class="form-control"
                           formControlName="fat">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 form-group">
                    <label>{{'app.product.form.protein' | trans}}</label>
                    <input type="number"
                           step="0.1"
                           class="form-control"
                           formControlName="protein">
                </div>
                <div class="col-xs-12 col-sm-4 form-group">
                    <label>{{'app.product.form.sugar' | trans}}</label>
                    <input type="number"
                           step="0.1"
                           class="form-control"
                           formControlName="sugar">
                </div>
                <div class="col-xs-12 col-sm-4 form-group">
                    <label>{{'app.product.form.gfat' | trans}}</label>
                    <input type="number"
                           step="0.1"
                           class="form-control"
                           formControlName="gfat">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 checkbox">
                    <label>
                        <input type="checkbox"
                               formControlName="vegan">
                        {{'app.product.form.vegan' | trans}}
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button class="btn btn-danger"
                            (click)="onDelete(inputProduct)"
                            *ngIf="inputProduct">
                        {{'app.common.delete' | trans}}
                    </button>
                    <button class="btn btn-primary"
                            [disabled]="productForm.invalid">
                        {{'app.common.submit' | trans}}
                    </button>
                </div>
            </div>
        </form>
    `,
})
export class ProductFormComponent implements OnInit {
    public productForm: FormGroup;
    public inputProduct?: Product;

    constructor(private router: Router,
                private formBuilder: FormBuilder,
                private productState: ProductState) {
    }

    @Input('product')
    set productModel(product: Product | undefined) {
        this.inputProduct = product;

        const config = !this.inputProduct
            ? this.getDefaultConfig()
            : this.map(this.inputProduct);

        this.productForm.setValue(config);
    }

    public ngOnInit(): void {
        const placeholder = this.getDefaultConfig();
        this.productForm = this.formBuilder.group(placeholder);
    }

    public onSubmit(): void {
        const productDto = this.map(this.productForm.value);

        const observable: Observable<any> = this.inputProduct
            ? this.productState.updateProduct({id: this.inputProduct.id, ...productDto})
            : this.productState.addProduct(productDto);

        observable.subscribe(() => this.router.navigate(['products']));
    }

    public onDelete(product: Product): void {
        this.productState
            .removeProduct(product.id)
            .subscribe(() => this.router.navigate(['products']));
    }

    private map(model: Product): ProductRequestDto {
        return {
            name: model.name,
            vegan: model.vegan,
            gr: model.gr,
            kcal: model.kcal,
            protein: model.protein,
            carbs: model.carbs,
            sugar: model.sugar,
            fat: model.fat,
            gfat: model.gfat,
            manufacturer: model.manufacturer,
        };
    }

    private getDefaultConfig(): ProductRequestDto {
        return {
            name: '',
            vegan: true,
            gr: 0,
            kcal: 0,
            protein: 0,
            carbs: 0,
            sugar: 0,
            fat: 0,
            gfat: 0,
            manufacturer: '',
        };
    }
}
