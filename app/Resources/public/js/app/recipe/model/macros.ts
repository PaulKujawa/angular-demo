import {MacrosDto} from './dto/macros.dto';

export class Macros {
    public kcal: number;
    public carbs: number;
    public protein: number;
    public fat: number;

    constructor(dto: MacrosDto) {
        this.kcal = dto.kcal;
        this.carbs = dto.carbs;
        this.protein = dto.protein;
        this.fat = dto.fat;
    }
}
