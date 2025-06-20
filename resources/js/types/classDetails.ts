/**
 * Interfaces for D&D class details
 * Based on the D&D API class information format
 */

/**
 * Represents a basic reference item with index, name and URL
 */
export interface ApiReference {
    index: string;
    name: string;
    url: string;
    _id?: string;
}

/**
 * Represents an option in a choice
 */
export interface OptionItem {
    option_type: string;
    item: ApiReference;
}

/**
 * Represents a set of options to choose from
 */
export interface OptionSet {
    option_set_type: string;
    options: OptionItem[];
}

/**
 * Represents a proficiency choice
 */
export interface ProficiencyChoice {
    desc: string;
    choose: number;
    type: string;
    from: OptionSet;
}

/**
 * Represents a starting equipment item
 */
export interface StartingEquipment {
    equipment: ApiReference;
    quantity: number;
}

/**
 * Represents a starting equipment option
 */
export interface StartingEquipmentOption {
    desc: string;
    choose: number;
    type: string;
    from: OptionSet;
}

/**
 * Represents a multiclassing prerequisite
 */
export interface MulticlassingPrerequisite {
    ability_score: ApiReference;
    minimum_score: number;
}

/**
 * Represents multiclassing information
 */
export interface Multiclassing {
    prerequisites: MulticlassingPrerequisite[];
    proficiencies: ApiReference[];
}

/**
 * Represents a complete D&D class
 */
export interface ClassData {
    index: string;
    name: string;
    hit_die: number;
    proficiency_choices: ProficiencyChoice[];
    proficiencies: ApiReference[];
    saving_throws: ApiReference[];
    starting_equipment: StartingEquipment[];
    starting_equipment_options: StartingEquipmentOption[];
    multi_classing: Multiclassing;
    subclasses: ApiReference[];
}
