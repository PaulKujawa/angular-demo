import {RecipeDetailDto} from './dto/recipe-detail.dto';
import {Ingredient} from './ingredient';
import {Instruction} from './instruction';
import {Photo} from './photo';
import {Recipe} from './recipe';

export class RecipeDetail extends Recipe {
    public ingredients: Ingredient[];
    public instructions: Instruction[];
    public photos: Photo[];
    public description: string;

    constructor(dto: RecipeDetailDto) {
        super(dto);

        this.ingredients = dto.ingredients.map((ingredientDto) => new Ingredient(ingredientDto));
        this.instructions = dto.instructions.map((instructionDto) => new Instruction(instructionDto));
        this.photos = dto.photos.map((photoDto) => new Photo(photoDto));
        this.description = dto.description;
    }
}
