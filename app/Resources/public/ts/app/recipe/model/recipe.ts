import {Ingredient} from "./ingredient";
import {Photo} from "./photo";
import {Cooking} from "./cooking";
import {Macros} from "./macros";

export class Recipe {
    constructor(public id: number,
                public name: string,
                public macros: Macros,
                public thumbnail?: Photo,
                public photos?: Photo,
                public ingredients?: Ingredient[],
                public cookings?: Cooking[]) {}
}