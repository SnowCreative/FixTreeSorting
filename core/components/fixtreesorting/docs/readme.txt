--------------------
FixTreeSorting
--------------------

Keep MODX resources in the correct menuindex order without gaps.


MODX doesn't automatically adjust menuindexes to make sure each set of children starts at 0 and proceeds sequentially. After adding new resources, moving resources into a different order, deleting resources, and duplicating resources, you can end up with menuindex sequences like 0, 1, 3, 5, 6, 10, or 6, 8, 9, 15, or even 2, 4, 6, 6, 6, 9, 12, 12. This can cause problems when fetching resources in menuindex order (if there are duplicate menuindexes) or creating a new resource (if there is a gap in the sequence, the new resource will get inserted in a gap instead of at the bottom of the list). This plugin fixes the problem by resorting the entire group of children whenever you edit and save a resource in that group, or manually drag a resource into a new order in the resource tree.
