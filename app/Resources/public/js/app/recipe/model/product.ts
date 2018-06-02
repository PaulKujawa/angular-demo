import {ProductDto} from 'app/recipe/model/dto/product.dto';

export class Product {
    public id: number;
    public name: string;
    public vegan: boolean;
    public gr: number;
    public kcal: number;
    public protein: number;
    public carbs: number;
    public sugar: number;
    public fat: number;
    public gfat: number;

    constructor(dto: ProductDto) {
        this.id = dto.id;
        this.name = dto.name;
        this.vegan = dto.vegan;
        this.gr = dto.gr;
        this.kcal = dto.kcal;
        this.protein = dto.protein;
        this.carbs = dto.carbs;
        this.sugar = dto.sugar;
        this.fat = dto.fat;
        this.gfat = dto.gfat;
    }
}
