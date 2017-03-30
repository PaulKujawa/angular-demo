import {Product} from '../product';

export class ProductRequestDto {
    name: string;
    vegan: boolean;
    gr: number;
    kcal: number;
    protein: number;
    carbs: number;
    sugar: number;
    fat: number;
    gfat: number;
    manufacturer?: string;

    constructor(dto: Product) {
        this.name = dto.name;
        this.vegan = dto.vegan;
        this.gr = dto.gr;
        this.kcal = dto.kcal;
        this.protein = dto.protein;
        this.carbs = dto.carbs;
        this.sugar = dto.sugar;
        this.fat = dto.fat;
        this.gfat = dto.gfat;
        this.manufacturer = dto.manufacturer;
    }
}
